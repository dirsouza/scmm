<?php

namespace SCMM\Controllers;

use SCMM\Configs\Dao;
use SCMM\Models\Model;

/**
 * Classe que controla o Login no sistema
 *
 * @author --diogo--
 */
class Login extends Model {
    //Variável constante que controla através de sessão se o usuário está logado
    const SESSION = "User";
    
    /**
     * Valida o login e senha do usuário
     * @param type $login
     * @param type $password
     * @return \SCMM\Controllers\Login
     */
    public static function login($login, $password) {
        try {
            //Faz a consulta se o usuáiro existe
            $sql = new Dao();
            $results = $sql->allSelect("SELECT * FROM tbusuario
                                        WHERE deslogin = :LOGIN", array(
                                            ':LOGIN' => $login
                                        ));

            //Verifica se houve retorno na consulta
            if (is_array($results) && count($results) === 0) {
                Model::returnError("Usuário ou senha incorreta.", "/scmm/login");
            }

            //Verifica se a senha é compatível
            if (password_verify($password, $results[0]['dessenha'])) {
                $user = new Login(); //Instancia a Classe login para acessar a Classe Model.
                $user->setData($results[0]); //Seta os dados na Classe Model
                session_regenerate_id(true); //Gera uma nova id de sessão
                $_SESSION[Login::SESSION] = $user->getValues(); //Atribui os dados da Classe Model a constante de sessão User
            } else {
                Model::returnError("Usuário ou senha incorreta", "/scmm/login");
            } 
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível validar os dados de Usuário.<br>".\PDOException($e->getMessage()), "/scmm/login");
        }  
    }
    
    /**
     * Limpa a constante de sessão User
     */
    public static function logout() {
        unset($_SESSION[Login::SESSION]);
    }
    
    /**
     * Verifica se o usuário fez login ou se ainda está logado
     */
    public static function verifyLogin() {
        if (
            !isset($_SESSION[Login::SESSION]) || //Verifica se a sessão existe
            !$_SESSION[Login::SESSION] || //Verifica se a sessão não contém dados
            !(int)$_SESSION[Login::SESSION]['Idusuario'] > 0 //Verifica se o id não é maior que zero
        ) {
            //Verifica se a sessão não existe
            if (isset($_SESSION[Login::SESSION])) {
                Model::returnError("Usuário não está logado", "/scmm/login");
            } else {
                header("location: /scmm/login");
            }
            exit;
        }
    }
    
    /**
     * Seta os dados do Usuário
     * @param type $idUser
     */
    public function getUser($idUser) {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT * FROM tbusuario
                                        WHERE idusuario = :IDUSUARIO", array(
                                            ':IDUSUARIO' => $idUser
                                        ));

            if ($result[0]['desadmin'] === 1) {
                $this->getUserAdmin($idUser);
            } else {
                $this->setData($result[0]);
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível obter os dados do Cliente.<br>".\PDOException($e->getMessage()), "/scmm/login");
        }
    }
    
    /**
     * Seta os dados do Usuário Administrador
     * @param type $idUser
     */
    private function getUserAdmin($idUser) {
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
            Model::returnError("Não foi possível obter os dados do Administrador.<br>".\PDOException($e->getMessage()), "/scmm/login");
        }
    }
}
