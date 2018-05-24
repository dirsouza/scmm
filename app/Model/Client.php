<?php

namespace App\Model;

use Core\Model;
use Lib\Dao;
use App\Model\User;

class Client extends Model
{
    /**
     * Adicionar usuário Cliente
     */
    public function addCliente()
    {
        if ($this->verifyData()) {
            $user = new User();
            $user->setData($this->getValues());
            $result = $user->addUsuario();

            if ($result > 0) {
                try {
                    $sql = new Dao();
                    $sql->allQuery("INSERT INTO tbcliente (idusuario,desnome,desemail)
                                    VALUES (:IDUSUARIO,:DESNOME,:DESEMAIL)", array(
                        ':IDUSUARIO' => $result,
                        ':DESNOME' => $this->getDesNome(),
                        ':DESEMAIL' => $this->getDesEmail()
                    ));
                } catch (\PDOException $e) {
                    User::deleteUsuario($result);
                    Model::returnError("Não foi possível Cadastrar o Cliente.<br>" . $e->getMessage(), $_SERVER['REQUEST_URI']);
                }
            } else {
                $this->recoveryData();
                $this->errorUser($result);
            }
        }
    }

    /**
     * Invoca o método de tratamento de erros da Model
     */
    private function errorUser($error)
    {
        if ($error == $this->getDesLogin()) {
            Model::returnError("Nome de Usuário já existe.", $_SERVER['REQUEST_URI']);
        }

        if ($error == $this->getDesEmail()) {
            Model::returnError("Endereço de E-mail já existe.", $_SERVER['REQUEST_URI']);
        }

        Model::returnError("O nome de usuário informado não atende os padrões.", $_SERVER['REQUEST_URI']);
    }

    /**
     * Retorna os dados dos Clientes
     * @return type array
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
     * @param type int
     * @return type array
     */
    public static function listClienteId(int $idUser)
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

    /**
     * Verifica se os dados são vazios
     * Caso SIM - Retorna False
     * Caso NAO - Retorna true
     * @return type boolean
     */
    private function verifyData()
    {
        foreach ($this->getValues() as $key => $value) {
            if (empty($value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Cria uma SESSÃO com os dados digitados pelo usuário
     */
    private function recoveryData()
    {
        $_SESSION['register'] = array(
            'desNome' => $this->getDesNome(),
            'desEmail' => $this->getDesEmail(),
            'desLogin' => $this->getDesLogin()
        );
    }
}