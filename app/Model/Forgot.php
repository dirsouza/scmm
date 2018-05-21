<?php

namespace App\Model;

use Core\Model;
use Core\Mailer;
use Lib\Dao;
use App\Model\User;

class Forgot extends Model
{
    const STRING_SECURITY = "c2NtbS5jb20uYnI="; //base64 = scmm.com.br
    const METHOD_ENCRYPT = "AES-128-CBC";

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
                $recovery = $sql->allSelect("CALL sp_clienteRecovery (:IDUSUARIO, :DESIP)", array(
                    ':IDUSUARIO' => $results[0]['idusuario'],
                    ':DESIP' => $_SERVER['REMOTE_ADDR']
                ));
                
                if (count($recovery) > 0) {
                    $code_encrypted = self::forgotEncrypt($recovery[0]['idrecovery'], Forgot::STRING_SECURITY);

                    $link = "http://local.scmm.com.br/forgot/reset?code=$code_encrypted";

                    $mailer = new Mailer($recovery[0]['desemail'], $recovery[0]['desnome'], "Redefinir Senha em SCMM", array(
                        'name' => $recovery[0]['desnome'],
                        'link' => $link
                    ));

                    $mailer->send();
                } else {
                    Model::returnError("Não foi possível recuperar a senha.", $_SERVER['REQUEST_URI']);
                }
            } else {
                Model::returnError("Endereço de E-mail não encontrado.", $_SERVER['REQUEST_URI']);
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível recuperar os dados.<br>" . $e->getMessage(), $_SERVER['REQUEST_URI']);
        }
    }

   private function forgotEncrypt($data, $key)
    {
        $encryption_key = base64_decode($key);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(Forgot::METHOD_ENCRYPT));
        $encrypted = openssl_encrypt($data, Forgot::METHOD_ENCRYPT, $encryption_key, 0, $iv);

        return base64_encode($encrypted . "::" . $iv);
    }

    public static function validForgotDecrypt($code)
    {
        try {
            $sql = new Dao();

            $results = $sql->allSelect("SELECT idrecovery FROM tbclienterecovery");

            $code_decrypted = self::forgotDecrypt($code, Forgot::STRING_SECURITY);

            if (is_array($results) && count($results) > 0) {
                foreach ($results as $result) {
                    foreach ($result as $key => $value) {
                        if ($value === $code_decrypted) {
                            $user = $sql->allSelect("SELECT * FROM tbclienterecovery a
                                                     INNER JOIN tbcliente b
                                                     USING (idusuario) 
                                                     WHERE a.idrecovery = :IDRECOVERY 
                                                     AND a.dtrecovery IS NULL", array(
                                ':IDRECOVERY' => $value
                            ));

                            if (is_array($user) && count($user) > 0) {
                                self::setForgotUser($value);
                                return $user[0];
                            } else {
                                Model::returnError("Código inválido ou inesistente.", $_SERVER['REQUEST_URI']);
                            }
                        }
                    }
                }
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível recuperar os dados.<br>" . $e->getMessage(), $_SERVER['REQUEST_URI']);
        }
    }

    private function forgotDecrypt($data, $key)
    {
        $encryption_key = base64_decode($key);
        list($encrypted_data, $iv) = explode("::", base64_decode($data), 2);

        return openssl_decrypt($encrypted_data, Forgot::METHOD_ENCRYPT, $encryption_key, 0, $iv);
    }

    private function setForgotUser($idrecovery)
    {
        try {
            $sql = new Dao();

            $sql->allQuery("UPDATE tbclienterecovery SET dtrecovery = NOW() WHERE idrecovery = :IDRECOVERY", array(
                ':IDRECOVERY' => $idrecovery
            ));
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível atualizar o registro de recovery.<br>" . $e->getMessage(), $_SERVER['REQUEST_URI']);
        }
    }

    public function setPassword($password)
    {
        try {
            $sql = new DAO();

            $sql->allQuery("UPDATE tbusuario SET dessenha = :DESSENHA WHERE idusuario = :IDUSUARIO", array(
                ':DESSENHA' => $password,
                ':IDUSUARIO' => $this->getIdUsuario()
            ));
        } catch (\PDOException $e) {
            Model::returnError("Erro ao redefinir a senha.<br>" . $e->getMessage(), $_SERVER['REQUEST_URI']);
        }
    }
}