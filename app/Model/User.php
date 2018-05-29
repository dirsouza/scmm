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
        try {
            $sql = new Dao();
            $sql->allQuery("INSERT INTO tbusuario (deslogin,dessenha,destipo)
                            VALUES (:DESLOGIN,:DESSENHA,:DESTIPO)", array(
                ':DESLOGIN' => $this->getDesLogin(),
                ':DESSENHA' => password_hash($this->getDesSenha(), PASSWORD_DEFAULT),
                ':DESTIPO' => $this->getDesTipo()
            ));
            
            return (int)$_SESSION[Dao::SESSION];
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível Cadastrar o Usuário.<br>" . $e->getMessage(), $_SERVER["REQUEST_URI"]);
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
    public function setUser(int $idUser)
    {
        $user = new Login();
        $user->getUser($idUser);
    }
}
