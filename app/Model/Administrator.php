<?php

namespace App\Model;

use Core\Model;
use Lib\Dao;
use App\Model\User;

class Administrator extends Model
{
    /**
     * Adicionar usuário Administrador
     * @param type $idUser
     */
    public function addAdministrador(int $idUser, array $data = array())
    {
        if ($this->verifyData($data)) {
            try {
                    $sql = new Dao();
                    $sql->allQuery("INSERT INTO tbadministrador (idusuario,desnome,descpf,desrg,desemail,destelefone)
                                VALUES (:IDUSUARIO,:DESNOME,:DESCPF,:DESRG:DESEMAIL,:DESTELEFONE)", array(
                        ':IDUSUARIO' => $idUser,
                        ':DESNOME' => $data['desNome'],
                        ':DESCPF' => $data['desCPF'],
                        ':DESRG' => $data['desRG'],
                        ':DESEMAIL' => $data['desEmail'],
                        ':DESTELEFONE' => $data['desTelefone']
                    ));
            } catch (\PDOException $e) {
                User::deleteUsuario($idUser);
                $this->recoveryData($data);
                Model::returnError("Não foi possível Cadastrar o Administrador.<br>" . $e->getMessage(), $_SERVER['REQUEST_URI']);
            }
        } else {
            User::deleteUsuario($idUser);
            $this->recoveryData($data);
            Model::returnError("Não foi possível Cadastrar o Administrador por estarem faltando dados.", $_SERVER['REQUEST_URI']);
        }
    }

    /**
     * Atualizar os dados do Administrador
     * @param type $idAdministrador
     */
    public function updateAdministrador($idUser)
    {
        try {
            $sql = new Dao();
            $sql->allQuery("UPDATE tbadministrador SET desnome = :DESNOME,
                                                       desrg = :DESRG,
                                                       desemail = :DESEMAIL
                            WHERE idusuario = :IDUSUARIO", array(
                ':IDUSUARIO' => $idUser,
                ':DESNOME' => $this->getDesNome(),
                ':DESRG' => $this->getDesRG(),
                ':DESEMAIL' => $this->getDesEmail()
            ));
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível Atualizar o Administrador.<br>" . $e->getMessage(), $_SERVER['REQUEST_URI']);
        }
    }

    /**
     * Atualiza a senha do Administrador
     * @param type $idUser
     */
    public function updateSenhaAdministrador($idUser)
    {
        try {
            $sql = new Dao();
            $sql->allQuery("UPDATE tbusuario SET dessenha = :DESSENHA
                            WHERE idusuario = :IDUSUARIO", array(
                ':IDUSUARIO' => $idUser,
                ':DESSENHA' => password_hash($this->getDesSenha(), PASSWORD_DEFAULT)
            ));
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível Atualizar a Senha do Administrador.<br>" . $e->getMessage(), $_SERVER['REQUEST_URI']);
        }
    }

    /**
     * Retorna os dados dos Administradores
     * @return type Array
     */
    public static function listAdministradores()
    {
        try {
            $sql = new Dao();
            $results = $sql->allSelect("SELECT * FROM tbadministrador");

            if (is_array($results) && count($results) > 0) {
                return $results;
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível recuperar os dados dos Administradores.<br>" . $e->getMessage(), $_SERVER['REQUEST_URI']);
        }
    }

    /**
     * Retorna os dados de um Administrador para atualização
     * @param type $idUser
     * @return type Array
     */
    public static function listAdministradorId($idUser)
    {
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
            Model::returnError("Não foi possível recuperar os dados do Administrador.<br>" . $e->getMessage(), $_SERVER['REQUEST_URI']);
        }
    }

    private function verifyData(array $data = array())
    {
        foreach ($data as $key => $value) {
            if (empty($value)) {
                return false;
            }
        }

        return true;
    }

    private function recoveryData()
    {
        $_SESSION['register'] = array(
            'desNome' => $this->getDesNome(),
            'desCPF' => $this->getDesCPF(),
            'desRG' => $this->getDesRG(),
            'desEmail' => $this->getDesEmail(),
            'desTelefone' => $this->getDesTelefone()
        );
    }
}