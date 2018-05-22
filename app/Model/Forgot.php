<?php

namespace App\Model;

use Core\Model;
use Core\Mailer;
use Lib\Dao;
use App\Model\User;

class Forgot extends Model
{
    const STRING_SECURITY = "c2NtbS5jb20uYnI="; //base64 = scmm.com.br

    public static function getForgot($email)
    {
        try {
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
                    $code_encrypted = self::forgotEncrypt($recovery[0]['idrecovery'], Forgot::STRING_SECURITY);

                    $link = "http://local.scmm.com.br/forgot/reset?code=$code_encrypted";

                    $mailer = new Mailer($recovery[0]['desemail'], $recovery[0]['desnome'], "Redefinir Senha em SCMM", array(
                        'name' => $recovery[0]['desnome'],
                        'link' => $link
                    ));

                    $mailer->send();
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

    public static function validForgotDecrypt($code, $password = null)
    {
        try {
            $sql = new Dao();
            $results = $sql->allSelect("SELECT idrecovery FROM tbclienterecovery");

            $code_decrypted = self::forgotDecrypt($code);

            if (is_array($results) && count($results) > 0) {
                foreach ($results as $result) {
                    foreach ($result as $key => $value) {
                        if ($value === $code_decrypted) {
                            $user = $sql->allSelect("SELECT * FROM tbclienterecovery a
                                                     INNER JOIN tbcliente b
                                                     USING (idusuario) 
                                                     WHERE a.idrecovery = :IDRECOVERY", array(
                                ':IDRECOVERY' => $value
                            ));

                            if (is_array($user) && count($user) > 0) {
                                if (empty($user[0]['idusuario'])) {
                                    self::setForgotUser($value);
                                } elseif ($password !== null) {
                                    self::setPassword($user[0]['idusuario'], $password);
                                }

                                return $user[0];
                            } else {
                                Model::returnError("Código inválido ou inesistente.");
                            }
                        }
                    }
                }
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível recuperar os dados.<br>" . $e->getMessage());
        }
    }

    private function forgotEncrypt($idRecovery, $key)
    {
        $encryption_id = base64_encode($idRecovery);
        $encryption_key = base64_decode($key);

        return base64_encode($encryption_id . "::" . $encryption_key);
    }

    private function forgotDecrypt($code)
    {
        $decryption = explode("::", base64_decode($code));
        
        return base64_decode($decryption[0]);
    }

    private function setForgotUser($idrecovery)
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

    private function setPassword($idUser, $password)
    {
        try {
            $sql = new DAO();

            $sql->allQuery("UPDATE tbusuario SET dessenha = :DESSENHA WHERE idusuario = :IDUSUARIO", array(
                ':DESSENHA' => $password,
                ':IDUSUARIO' => $idUser
            ));
        } catch (\PDOException $e) {
            Model::returnError("Erro ao redefinir a senha.<br>" . $e->getMessage());
        }
    }
}