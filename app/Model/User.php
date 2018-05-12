<?php

namespace App\Model;

use Core\Model;
use Lib\Dao;
use App\Model\Login;

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
                $sql->allQuery("INSERT INTO tbusuario (deslogin,dessenha,destipo)
                                VALUES (:DESLOGIN,:DESSENHA,:DESTIPO)", array(
                                    ':DESLOGIN' => $this->getDesLogin(),
                                    ':DESSENHA' => password_hash($this->getDesSenha(), PASSWORD_DEFAULT),
                                    ':DESTIPO' => (array_key_exists("DesTipo", $this->getValues())) ? $this->getDesTipo() : 0
                                ));

                $idUser = $_SESSION[Dao::SESSION];
                
                (array_key_exists("DesTipo", $this->getValues())) ? $this->addAdministrador($idUser) : $this->addCliente($idUser);

                $this->setUser($idUser);
            } else {
                $this->recoveryData();
                Model::returnError("Nome de usuário informado já existe no banco de dados.", $_SERVER["REQUEST_URI"]);
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível Cadastrar o Usuário.<br>".$e->getMessage(), $_SERVER["REQUEST_URI"]);
        }
    }
    
    /**
     * Adicionar usuário Cliente
     * @param type $idUser
     */
    private function addCliente($idUser) {
        try {
            $sql = new Dao();
            $sql->allQuery("INSERT INTO tbcliente (idusuario,desnome,desemail)
                            VALUES (:IDUSUARIO,:DESNOME,:DESEMAIL)", array(
                                ':IDUSUARIO' => $idUser,
                                ':DESNOME' => $this->getDesNome(),
                                ':DESEMAIL' => $this->getDesEmail()
                            ));
        } catch (\PDOException $e) {
            $this->deleteUsuario($idUser);
            Model::returnError("Não foi possível Cadastrar o Cliente.<br>".$e->getMessage(), $_SERVER['REQUEST_URI']);
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
            Model::returnError("Não foi possível Cadastrar o Administrador.<br>".$e->getMessage(), $_SERVER['REQUEST_URI']);
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
            Model::returnError("Não foi possível Atualizar o Administrador.<br>".$e->getMessage(), $_SERVER['REQUEST_URI']);
        }
    }
    
    /**
     * Atualiza a senha do Administrador
     * @param type $idUser
     */
    public function updateSenhaAdministrador($idAdministrador) {
        try {
            $sql = new Dao();
            $sql->allQuery("UPDATE tbusuario SET dessenha = :DESSENHA
                            WHERE idusuario = :IDUSUARIO", array(
                                ':IDUSUARIO' => $idAdministrador,
                                ':DESSENHA' => password_hash($this->getDesSenha(), PASSWORD_DEFAULT)
                            ));
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível Atualizar a Senha do Administrador.<br>".$e->getMessage(), $_SERVER['REQUEST_URI']);
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
            Model::returnError("Não foi possível Excluir o Administrador.<br>".$e->getMessage(), $_SERVER['REQUEST_URI']);
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
            Model::returnError("Não foi possível recuperar os dados dos Administradores.<br>".$e->getMessage(), $_SERVER['REQUEST_URI']);
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
            Model::returnError("Não foi possível recuperar os dados do Administrador.<br>".$e->getMessage(), $_SERVER['REQUEST_URI']);
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
            Model::returnError("Não foi possível recuperar os dados dos Clientes.<br>".$e->getMessage(), $_SERVER['REQUEST_URI']);
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
            Model::returnError("Não foi possível recuperar os dados do Cliente.<br>".$e->getMessage(), $_SERVER['REQUEST_URI']);
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
                'desEmail' => $this->getDesEmail(),
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
