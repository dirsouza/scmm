<?php

namespace App\Model;

use Core\Model;
use Lib\Dao;
use App\Model\User;

class Client extends Model
{
    /**
     * Adicionar usuário Cliente
     * @param type $idUser
     */
    public function addCliente(int $idUser)
    {
        if ($this->verifyData()) {
            try {
                $sql = new Dao();
                $sql->allQuery("INSERT INTO tbcliente (idusuario,desnome,desemail)
                            VALUES (:IDUSUARIO,:DESNOME,:DESEMAIL)", array(
                    ':IDUSUARIO' => $idUser,
                    ':DESNOME' => $this->getDesNome(),
                    ':DESEMAIL' => $this->getDesEmail()
                ));
            } catch (\PDOException $e) {
                User::deleteUsuario($idUser);
                Model::returnError("Não foi possível Cadastrar o Cliente.<br>" . $e->getMessage(), $_SERVER['REQUEST_URI']);
            }
        } else {
            User::deleteUsuario($idUser);
            $this->recoveryData();
            Model::returnError("Não foi possível Cadastrar o Cliente por estarem faltando dados.", $_SERVER['REQUEST_URI']);
        }
    }

    /**
     * Retorna os dados dos Clientes
     * @return type Array
     */
    public static function listClientes()
    {
        try {
            $sql = new Dao();
            $results = $sql->allSelect("SELECT * FROM tbcliente
                                        INNER JOIN tbusuario
                                        USING (idusuario)");

            if (is_array($results) && count($results) > 0) {
                return $results;
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível recuperar os dados dos Clientes.<br>" . $e->getMessage(), $_SERVER['REQUEST_URI']);
        }
    }

    /**
     * Retorna os dados de um Cliente
     * @param type $idUser
     * @return type Array
     */
    public static function listClienteId($idUser)
    {
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
            Model::returnError("Não foi possível recuperar os dados do Cliente.<br>" . $e->getMessage(), $_SERVER['REQUEST_URI']);
        }
    }

    private function verifyData()
    {
        foreach ($this->getValues() as $key => $value) {
            if (empty($value)) {
                return false;
            }
        }

        return true;
    }

    public function recoveryData()
    {
        $_SESSION['register'] = array(
            'desNome' => $this->getDesNome(),
            'desEmail' => $this->getDesEmail(),
            'desLogin' => $this->getDesLogin()
        );
    }
}