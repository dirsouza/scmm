<?php

namespace App\Model;

use Core\Model;
use Lib\Dao;
use App\Model\User;

class Client extends Model
{
    private $error = [];
    
    /**
     * Adicionar usuário Cliente
     */
    public function addCliente()
    {
        $vData  = $this->verifyData();
        $vUser = $this->verifyUsuario();

        if ($vData === true && $vUser === true) {
            $user = new User();
            $user->setData($this->getValues());
            $id = $user->addUsuario();

            try {
                $sql = new Dao();
                $sql->allQuery("INSERT INTO tbcliente (idusuario,desnome,desemail)
                                VALUES (:IDUSUARIO,:DESNOME,:DESEMAIL)", array(
                    ':IDUSUARIO' => $id,
                    ':DESNOME' => $this->getDesNome(),
                    ':DESEMAIL' => $this->getDesEmail()
                ));

                $user->setUser($id);
            } catch (\PDOException $e) {
                $this->recoveryData();
                User::deleteUsuario($id);
                Model::returnError("Não foi possível Cadastrar o Cliente.<br>" . $e->getMessage(), $_SERVER['REQUEST_URI']);
            }
        } else {
            $this->recoveryData();
            if (is_array($vData) && is_array($vUser)) {
                $this->errorUser(array_merge($vData, $vUser));
            } else {
                if (is_array($vData) && !is_array($vUser)) {
                    $this->errorUser($vData);
                } else {
                    $this->errorUser($vUser);
                }
            }
        }
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
     * Verifica se o nome de Usuário ou E-mail já existem
     * Caso SIM - Retorna o resultado encontrado
     * Caso NAO - Retorna true
     */
    private function verifyUsuario()
    {
        $sql = new Dao();
        // Obtém os dados da tabela Usuario
        $result = $sql->allSelect("SELECT * FROM tbusuario WHERE deslogin = :DESLOGIN", array(
            ':DESLOGIN' => $this->getDesLogin()
        ));

        if (is_array($result) && count($result) > 0) {
            $this->error[] = "Nome de <b>Usuário</b> já existe.";
        }

        // Obtém os dados da tabela Cliente
        $result = $sql->allSelect("SELECT * FROM tbcliente WHERE desemail = :DESEMAIL", array(
            ':DESEMAIL' => $this->getDesEmail()
        ));

        if (is_array($result) && count($result) > 0) {
            $this->error[] = "Endereço de <b>E-mail</b> já existe.";
        }

        // Verifica se o nome de usuário não contém caracteres especiais
        if (preg_match('/[^a-z.\-_\d]/', $this->getDesLogin())) {
            $this->error[] = "O nome de <b>Usuário</b> informado não atende os padrões.";
        }

        if (count($this->error) > 0) {
            return $this->error;
        }

        return true;
    }

    /**
     * Invoca o método de tratamento de erros da Model
     * @param type array
     */
    private function errorUser(array $error)
    {
        foreach ($error as $key => $value) {
            ($key == 0) ? $msg = $value : $msg .= "<br>" . $value;
        }

        Model::returnError($msg, $_SERVER['REQUEST_URI']);
    }

    /**
     * Verifica se os dados são vazios
     * Caso SIM - Retorna False
     * Caso NAO - Retorna true
     * @return type boolean
     */
    private function verifyData()
    {
        $error = [];

        foreach ($this->getValues() as $key => $value) {
            if (empty($value) && $key != "DesTipo" && $key != "DesReSenha") {
                $error[] = "O campo <b>" . preg_replace('/Des/',"", $key) . "</b> não foi informado.";
            }
        }

        if (count($error) > 0) {
            return $error;
        }

        return true;
    }

    /**
     * Cria uma SESSÃO com os dados digitados pelo usuário
     */
    private function recoveryData()
    {
        $_SESSION['restoreData'] = array(
            'desNome' => $this->getDesNome(),
            'desEmail' => $this->getDesEmail(),
            'desLogin' => $this->getDesLogin()
        );
    }
}