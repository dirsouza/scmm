<?php

namespace App\Model;

use Core\Model;
use Core\Mailer;
use Lib\Dao;
use App\Model\User;

class Forgot extends Model
{
    // Chave encriptada (frase de segurança)
    private const STRING_SECURITY = "c2NtbS5jb20uYnI="; //base64 = scmm.com.br

    /**
     * Recebe o e-mail do cliente para envio
     */
    public static function getForgot($email)
    {
        try {
            // Consuta no banco se o e-mail existe
            $sql = new Dao();
            $results = $sql->allSelect("SELECT * FROM tbusuario a
                             INNER JOIN tbcliente b
                             USING (idusuario)
                             WHERE b.desemail = :EMAIL", array(
                                ':EMAIL' => $email
                             ));
            
            if (is_array($results) && count($results) > 0) {
                $idRecovery = self::insertRecovery($results[0]['idusuario']);
                $recovery = self::getRecovery($idRecovery);
                
                if (count($recovery) > 0) {
                    // Recebe a chave encriptada
                    $code_encrypted = self::forgotEncrypt($recovery[0]['idrecovery'], Forgot::STRING_SECURITY);

                    // Recebe o link para envio do e-mail
                    $link = "http://local.scmm.com.br/forgot/reset?code=$code_encrypted";

                    // Instancia a Classe Mailer para envio do e-mail
                    $mailer = new Mailer($recovery[0]['desemail'], $recovery[0]['desnome'], "Redefinir Senha em SCMM", array(
                        'name' => $recovery[0]['desnome'],
                        'link' => $link
                    ));

                    if ($mailer->send()) {
                        return true;
                    } else {
                        return $mailer->ErrorInfo;
                    }
                } else {
                    Model::returnError("Não foi possível recuperar a senha.");
                }
            } else {
                Model::returnError("Endereço de E-mail não encontrado.");
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível recuperar os dados.<br>" . $e->getMessage());
        }
    }

    /**
     * Insere no banco de dados os dados de recoperação
     */
    private function insertRecovery(int $idUser)
    {
        try {
            $sql = new Dao();
            $sql->allQuery("INSERT INTO tbclienterecovery (idusuario, desip)
                            VALUES (:IDUSUARIO, :DESIP)", array(
                ':IDUSUARIO' => $idUser,
                ':DESIP' => $_SERVER['REMOTE_ADDR']
            ));

            return $_SESSION[Dao::SESSION];
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível inserir os dados.<br>" . $e->getMessage());
        }
    }

    /**
     * Recupera do banco de dados os dados para redefinir a senha
     */
    private function getRecovery(int $idRecovery)
    {
        try {
            $sql = new Dao();
            $recovery = $sql->allSelect("SELECT * FROM tbclienterecovery a
                                         INNER JOIN tbcliente b
                                         USING (idusuario)
                                         WHERE idrecovery = :IDRECOVERY", array(
                ':IDRECOVERY' => $idRecovery
            ));
            
            return $recovery;
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível recuperar os dados.<br>" . $e->getMessage());
        }
    }

    /**
     * Valida no banco de dados o código de recuperação
     */
    public static function validForgotDecrypt($code, $password = null)
    {
        try {
            $sql = new Dao();
            $results = $sql->allSelect("SELECT * FROM tbclienterecovery a
                                        INNER JOIN tbcliente b
                                        USING (idusuario) 
                                        WHERE a.idrecovery = :IDRECOVERY
                                        AND a.dtrecovery IS NULL", array(
                ':IDRECOVERY' => $code
            ));
            
            if (is_array($results) && count($results) > 0) {
                self::setForgotUser($results[0]['idrecovery']);

                return $results[0];
            } else {
                Model::returnError("O código não é mais válido.");
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível recuperar os dados.<br>" . $e->getMessage());
        }
    }

    /**
     * Encripta a chave de recuperação
     */
    private function forgotEncrypt($idRecovery, $key)
    {
        $encryption_id = base64_encode($idRecovery);
        $encryption_key = base64_decode($key);

        return base64_encode($encryption_id . "::" . $encryption_key);
    }

    /**
     * Decripta a chave de recuperação
     */
    public static function forgotCodeDecrypt($code)
    {
        $decryption = explode("::", base64_decode($code));
        
        return base64_decode($decryption[0]);
    }

    /**
     * Atualiza no banco de dados a data que o link de recuperação foi validado
     */
    private function setForgotUser(int $idrecovery)
    {
        try {
            $sql = new Dao();
            $sql->allQuery("UPDATE tbclienterecovery SET dtrecovery = NOW() WHERE idrecovery = :IDRECOVERY", array(
                ':IDRECOVERY' => $idrecovery
            ));
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível atualizar o registro de recovery.<br>" . $e->getMessage());
        }
    }

    /**
     * Atualiza a senha do usuário no banco de dados
     */
    public static function setPassword(int $idUser, $password)
    {
        if (self::validatePassword($password)) {
            try {
                $sql = new DAO();
                $sql->allQuery("UPDATE tbusuario SET dessenha = :DESSENHA WHERE idusuario = :IDUSUARIO", array(
                    ':DESSENHA' => password_hash($password, PASSWORD_DEFAULT),
                    ':IDUSUARIO' => $idUser
                ));
            } catch (\PDOException $e) {
                Model::returnError("Erro ao redefinir a senha.<br>" . $e->getMessage());
            }
        } else {
            Model::returnError("A senha não é válida<br>Solicite nova redefinição.");
        }
    }

    /**
     * Valida se a senha não está vazia
     */
    private function validatePassword($password)
    {
        if (empty(trim($password))) {
            return false;
        }

        return true;
    }
}