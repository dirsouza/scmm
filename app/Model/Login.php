<?php

namespace App\Model;

use Core\Model;
use Lib\Dao;

/**
 * Classe que controla o Login no sistema
 */
class Login extends Model
{
    //Variável constante que controla através de sessão se o usuário está logado
    const SESSION = "User";

    /**
     * Valida o login e senha do usuário
     * @param type $login
     * @param type $password
     * @return \SCMM\Controllers\Login
     */
    public static function login(string $login, string $password)
    {
        try {
            //Faz a consulta se o usuáiro existe
            $sql = new Dao();
            $results = $sql->allSelect("SELECT * FROM tbusuario
                                        WHERE deslogin = :LOGIN", array(
                ':LOGIN' => $login
            ));

            //Verifica se houve retorno na consulta
            if (is_array($results) && count($results) === 0) {
                Model::returnError("Usuário ou senha incorreta.", $_SERVER['REQUEST_URI']);
            }

            //Verifica se a senha é compatível
            if (password_verify($password, $results[0]['dessenha'])) {
                $user = new Login(); //Instancia a Classe login para acessar a Classe Model.
                $user->setData($results[0]); //Seta os dados na Classe Model
                session_regenerate_id(true); //Gera uma nova id de sessão
                $_SESSION[self::SESSION] = $user->getValues(); //Atribui os dados da Classe Model a constante de sessão User
                
                //Faz o direcionamento de rotas
                if ($_SESSION[self::SESSION]['Destipo'] == 1) {
                    header('location: /admin');
                    exit;
                } else {
                    header('location: /client');
                    exit;
                }
            } else {
                Model::returnError("Usuário ou senha incorreta", $_SERVER['REQUEST_URI']);
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível validar os dados de Usuário.<br>" . $e->getMessage(), $_SERVER['REQUEST_URI']);
        }
    }

    /**
     * Limpa a constante de sessão User
     */
    public static function logout()
    {
        unset($_SESSION[Login::SESSION]);
    }

    /**
     * Verifica se o usuário fez login ou se ainda está logado
     */
    public static function verifyLogin()
    {
        if (
            !isset($_SESSION[self::SESSION]) || //Verifica se a sessão existe
            empty($_SESSION[self::SESSION]) || //Verifica se a sessão está vazia
            !(int)$_SESSION[self::SESSION]['Idusuario'] > 0 //Verifica do ID é maior que ZERO
        ) {
            //Verifica se a sessão não existe
            if (isset($_SESSION[self::SESSION])) {
                Model::returnError("Usuário não está logado", "/login");
            } else {
                header("location: /login");
                exit;
            }
        }
    }

    /**
     * Seta os dados do Usuário
     * @param type $idUser
     */
    public function getUser(int $idUser)
    {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT * FROM tbusuario
                                        WHERE idusuario = :IDUSUARIO", array(
                ':IDUSUARIO' => $idUser
            ));

            if ($result[0]['destipo'] === 1) {
                $this->getUserAdmin($idUser);
            } else {
                $this->getUserClient($idUser);
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível obter os dados do usuário.<br>" . $e->getMessage(), $_SERVER['REQUEST_URI']);
        }
    }

    /**
     * Seta os dados do Usuário Administrador
     * @param type int
     */
    private function getUserAdmin(int $idUser)
    {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT * FROM tbusuario
                                        INNER JOIN tbadministrador
                                        USING (idusuario)
                                        WHERE idusuario = :IDUSUARIO", array(
                ':IDUSUARIO' => $idUser
            ));

            $this->setData($result[0]);
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível obter os dados do Administrador.<br>" . $e->getMessage(), $_SERVER['REQUEST_URI']);
        }
    }

    /**
     * Seta os dados do Usuário Cliente
     * @param type int
     */
    private function getUserClient(int $idUser)
    {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT * FROM tbusuario
                                       INNER JOIN tbcliente
                                       USING (idusuario)
                                       WHERE idusuario = :IDUSUARIO", array(
                ':IDUSUARIO' => $idUser
            ));
            
            $this->setData($result[0]);
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível obter os dados do Cliente.<br>" . $e->getMessage(), $_SERVER['REQUEST_URI']);
        }
    }
}
