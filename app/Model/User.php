<?php

namespace App\Model;

use Core\Model;
use Lib\Dao;
use App\Model\Login;

/**
 * Classe para cadastrar e controlar os Usuários
 */
class User extends Model
{
    /**
     * Adiciona um novo Usuário e retorna o ID
     * @return type int
     */
    public function addUsuario()
    {
        $result = $this->verifyUsuario();
        
        if ($result === true) {
            if ($this->verifyData()) {
                try {
                    $sql = new Dao();
                    $sql->allQuery("INSERT INTO tbusuario (deslogin,dessenha,destipo)
                                    VALUES (:DESLOGIN,:DESSENHA,:DESTIPO)", array(
                        ':DESLOGIN' => $this->getDesLogin(),
                        ':DESSENHA' => password_hash($this->getDesSenha(), PASSWORD_DEFAULT),
                        ':DESTIPO' => (array_key_exists("DesTipo", $this->getValues())) ? $this->getDesTipo() : 0
                    ));

                    $idUser = $_SESSION[Dao::SESSION];

                    $this->setUser($idUser);
                    
                    return (int)$idUser;
                } catch (\PDOException $e) {
                    Model::returnError("Não foi possível Cadastrar o Usuário.<br>" . $e->getMessage(), $_SERVER["REQUEST_URI"]);
                }
            } else {
                return false;
            }
        } else {
            return $result;
        }
    }

    /**
     * Deleta o usuário Administrador ou Cliente
     * @param type int
     */
    public static function deleteUsuario(int $idUser)
    {
        try {
            $sql = new Dao();
            $sql->allQuery("DELETE FROM tbusuario
                            WHERE idusuario = :IDUSUARIO", array(
                ':IDUSUARIO' => $idUser
            ));
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível Excluir o Administrador.<br>" . $e->getMessage(), $_SERVER['REQUEST_URI']);
        }
    }
    
    /**
     * Verifica se os dados estão vazios e se o nome de usuário não contém caracteres especiais
     * Caso SIM - Retorna false
     * Caso NAO - Retorna true
     */
    private function verifyData()
    {
        if (empty($this->getDesLogin()) || preg_match('/[^a-z.\-_\d]/', $this->getDesLogin())) {
            return false;
        }
        
        if (empty($this->getDesSenha())) {
            return false;
        }
        
        return true;
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
            return $result[0]['deslogin'];
        }

        // Obtém os dados da tabela Cliente
        $result = $sql->allSelect("SELECT * FROM tbcliente WHERE desemail = :DESEMAIL", array(
            ':DESEMAIL' => $this->getDesEmail()
        ));

        if (is_array($result) && count($result) > 0) {
            return $result[0]['desemail'];
        }

        return true;
    }

    /**
     * Verifica se a senha é válida
     * Caso SIM - Retorna true
     * Caso NAO - Retorna false
     * @param type int
     * @param type string
     */
    public function verifyPass(int $id, string $password)
    {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT * FROM tbusuario
                                    WHERE idusuario = :IDUSUARIO", array(
                ':IDUSUARIO' => $id
            ));

            if (is_array($result) && count($result) > 0) {
                if (password_verify($password, $result[0]['dessenha'])) {
                    return true;
                } else {
                    return false;
                }
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível retornar os dados.<br>" . $e->getMessage());
        }
    }

    /**
     * Instacia a Classe Login e invoca a função getUser para alimentar o setData da Classe Model
     * com os dados do usuário
     * @param type int
     */
    private function setUser(int $idUser)
    {
        $user = new Login();
        $user->getUser($idUser);
    }
}
