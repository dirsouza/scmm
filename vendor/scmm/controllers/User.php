<?php

namespace SCMM\Controllers;

use SCMM\Configs\Dao;
use SCMM\Models\Model;
use SCMM\Controllers\Login;

/**
 * Classe para cadastrar e controlar os Usuários
 *
 * @author --diogo--
 */
class User extends Model {
    
    /**
     * Adiciona um novo Usuário
     */
    public function addUsuario() {
        try {
            if ($this->verifyUsuario()) {
                $sql = new Dao();
                $sql->allQuery("INSERT INTO tbusuario (deslogin,dessenha,desadmin)
                                VALUES (:DESLOGIN,:DESSENHA,:DESADMIN)", array(
                                    ':DESLOGIN' => $this->getDesLogin(),
                                    ':DESSENHA' => password_hash($this->getDesSenha(), PASSWORD_DEFAULT),
                                    ':DESADMIN' => (array_key_exists("DesAdmin", $this->getValues())) ? $this->getDesAdmin() : 0
                                ));

                $idUser = $_SESSION[Dao::SESSION];
                
                (array_key_exists("DesAdmin", $this->getValues())) ? $this->addAdministrador($idUser) : $this->addCliente($idUser);

                $this->setUser($idUser);
            } else {
                $this->recoveryData();
                Model::returnError("Nome de usuário informado já existe no banco de dados.", $_SERVER["REQUEST_URI"]);
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível Cadastrar o Usuário.<br>".\PDOException($e->getMessage()), $_SERVER["REQUEST_URI"]);
        }
    }
    
    /**
     * Adicionar usuário Cliente
     * @param type $idUser
     */
    private function addCliente($idUser) {
        try {
            $sql = new Dao();
            $sql->allQuery("INSERT INTO tbcliente (idusuario,desnome)
                            VALUES (:IDUSUARIO,:DESNOME)", array(
                                ':IDUSUARIO' => $idUser,
                                ':DESNOME' => $this->getDesNome()
                            ));
        } catch (\PDOException $e) {
            $this->deleteUsuario($idUser);
            Model::returnError("Não foi possível Cadastrar o Cliente.<br>".\PDOException($e->getMessage()), "/scmm/register");
        }
    }

    /**
     * Adicionar usuário Administrador
     * @param type $idUser
     */
    private function addAdministrador($idUser) {
        try {
            $sql = new Dao();
            $sql->allQuery("INSERT INTO tbadministrador (idusuario,desnome,descpf,desrg,desemail,destelefone)
                            VALUES (:IDUSUARIO,:DESNOME,:DESCPF,:DESRG:DESEMAIL,:DESTELEFONE)", array(
                                ':IDUSUARIO' => $idUser,
                                ':DESNOME' => $this->getDesNome(),
                                ':DESCPF' => $this->getDesCPF(),
                                ':DESRG' => $this->getDesRG(),
                                ':DESEMAIL' => $this->getDesEmail(),
                                ':DESTELEFONE' => $this->getDesTelefone()
                            ));
        } catch (\PDOException $e) {
            $this->deleteUsuario($idUser);
            Model::returnError("Não foi possível Cadastrar o Administrador.<br>".\PDOException($e->getMessage()), "/scmm/admin/user/create");
        }
    }
    
    /**
     * Atualizar os dados do Administrador
     * @param type $idAdministrador
     */
    public function updateAdministrador($idAdministrador) {
        try {
            $sql = new Dao();
            $sql->allQuery("UPDATE tbadministrador SET desnome = :DESNOME,
                                                       desrg = :DESRG,
                                                       desemail = :DESEMAIL
                            WHERE idadministrador = :IDADMINISTRADOR", array(
                                ':IDADMINISTRADOR' => $idAdministrador,
                                ':DESNOME' => $this->getDesNome(),
                                ':DESRG' => $this->getDesRG(),
                                ':DESEMAIL' => $this->getDesEmail()
                            ));
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível Atualizar o Administrador.<br>".\PDOException($e->getMessage()), "/scmm/admin/user/update/".$idAdministrador);
        }
    }
    
    /**
     * Atualiza a senha do Administrador
     * @param type $idUser
     */
    public function updateSenhaAdministrador($idUser) {
        try {
            $sql = new Dao();
            $sql->allQuery("UPDATE tbusuario SET dessenha = :DESSENHA
                            WHERE idusuario = :IDUSUARIO", array(
                                ':IDUSUARIO' => $idUser,
                                ':DESSENHA' => password_hash($this->getDesSenha(), PASSWORD_DEFAULT)
                            ));
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível Atualizar a Senha do Administrador.<br>".\PDOException($e->getMessage()), "/scmm/admin/user");
        }
    }
    
    /**
     * Deleta o usuário Administrador ou Cliente
     * @param type $idUser
     */
    public function deleteUsuario($idUser) {
        try {
            $sql = new Dao();
            $sql->allQuery("DELETE FROM tbusuario
                            WHERE idusuario = :IDUSUARIO", array(
                                ':IDUSUARIO' => $idUser
                            ));
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível Excluir o Administrador.<br>".\PDOException($e->getMessage()), "/scmm/admin/user");
        }
    }
    
    /**
     * Retorna os dados dos Administradores
     * @return type Array
     */
    public static function listAdministradores() {
        try {
            $sql = new Dao();
            $results = $sql->allSelect("SELECT * FROM tbadministrador");

            if (is_array($results) && count($results) > 0) {
                return $results;
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível recuperar os dados dos Administradores.<br>".\PDOException($e->getMessage()), "/scmm/admin/user");
        }
    }
    
    /**
     * Retorna os dados de um Administrador para atualização
     * @param type $idUser
     * @return type Array
     */
    public static function listAdministradorId($idUser) {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT * FROM tbadministrador
                                        WHERE idusuario = :IDUSUARIO", array(
                                            ':IDUSUARIO' => $idUser
                                        ));

            if (is_array($result) && count($result) > 0) {
                return $result;
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível recuperar os dados do Administrador.<br>".\PDOException($e->getMessage()), "/scmm/admin/user/update/".$idUser);
        }
    }

    /**
     * Retorna os dados dos Clientes
     * @return type Array
     */
    public static function listClientes() {
        try {
            $sql = new Dao();
            $results = $sql->allSelect("SELECT * FROM tbcliente
                                        INNER JOIN tbusuario
                                        USING (idusuario)");

            if (is_array($results) && count($results) > 0) {
                return $results;
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível recuperar os dados dos Clientes.<br>".\PDOException($e->getMessage()), "/scmm/admin/client");
        }
    }

    /**
     * Retorna os dados de um Cliente
     * @param type $idUser
     * @return type Array
     */
    public static function listClienteId($idUser) {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT * FROM tbcliente
                                        WHERE idusuario = :IDUSUARIO", array(
                                            ':IDUSUARIO' => $idUser
                                        ));

            if (is_array($result) && count($result) > 0) {
                return $result;
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível recuperar os dados do Cliente.<br>".\PDOException($e->getMessage()), "/scmm/admin/user/update/".$idUser);
        }
    }

    private function verifyUsuario() {
        $sql = new Dao();
        $result = $sql->allSelect("SELECT * FROM tbusuario WHERE deslogin = :DESLOGIN", array(
            ':DESLOGIN' => $this->getDesLogin()
        ));
        
        if (is_array($result) && count($result) > 0) {
            return false;
        }

        return true;
    }

    private function recoveryData() {
        if ($_SERVER["REQUEST_URI"] === "/scmm/register") {
            $_SESSION['register'] = array(
                'desNome' => $this->getDesNome(),
                'desLogin' => $this->getDesLogin()
            );
        }        
    }

    /**
     * Instacia a Classe Login e convoca a função getUser para alimentar o setData da Classe Model
     * @param type $idUser
     */
    private function setUser($idUser) {
        $user = new Login();
        $user->getUser($idUser);
    }
}
