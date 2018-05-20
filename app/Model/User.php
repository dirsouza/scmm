<?php

namespace App\Model;

use Core\Model;
use Lib\Dao;
use App\Model\Login;
use App\Model\Administrator;
use App\Model\Client;

/**
 * Classe para cadastrar e controlar os Usuários
 */
class User extends Model
{
    /**
     * Adiciona um novo Usuário
     */
    public function addUsuario()
    {
        if ($this->verifyUsuario() && $this->verifyData()) {
            try {
                $sql = new Dao();
                $sql->allQuery("INSERT INTO tbusuario (deslogin,dessenha,destipo)
                                VALUES (:DESLOGIN,:DESSENHA,:DESTIPO)", array(
                    ':DESLOGIN' => $this->getDesLogin(),
                    ':DESSENHA' => password_hash($this->getDesSenha(), PASSWORD_DEFAULT),
                    ':DESTIPO' => (array_key_exists("DesTipo", $this->getValues())) ? $this->getDesTipo() : 0
                ));

                $idUser = $_SESSION[Dao::SESSION];

                if (array_key_exists("DesTipo", $this->getValues())) {
                    $admin = new Administrator();
                    $admin->addAdministrador($idUser, array(
                        'desNome' => $this->getDesNome(),
                        'desCPF' => $this->getDesCPF(),
                        'desRG' => $this->getDesRG(),
                        'desEmail' => $this->getDesEmail(),
                        'desTelefone' => $this->getDesTelefone()
                    ));
                } else {
                    $client = new Client();
                    $client->addCliente($idUser, array(
                        'desNome' => $this->getDesNome(),
                        'desEmail' => $this->getDesEmail(),
                        'desLogin' => $this->getDesLogin()
                    ));
                }

                $this->setUser($idUser);
            } catch (\PDOException $e) {
                Model::returnError("Não foi possível Cadastrar o Usuário.<br>" . $e->getMessage(), $_SERVER["REQUEST_URI"]);
            }
        } else {
            $client = new Client();
            $client->recoveryData();
            Model::returnError("Nome de usuário informado já existe no banco de dados ou estão faltando dados.", $_SERVER["REQUEST_URI"]);
        }
    }

    /**
     * Deleta o usuário Administrador ou Cliente
     * @param type $idUser
     */
    public static function deleteUsuario($idUser)
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
    
    private function verifyData()
    {
        if (empty($this->getDesLogin())) {
            return false;
        }
        
        if (empty($this->getDesSenha())) {
            return false;
        }
        
        return true;
    }

    private function verifyUsuario()
    {
        $sql = new Dao();
        $result = $sql->allSelect("SELECT * FROM tbusuario WHERE deslogin = :DESLOGIN", array(
            ':DESLOGIN' => $this->getDesLogin()
        ));

        if (is_array($result) && count($result) > 0) {
            return false;
        }

        return true;
    }

    /**
     * Instacia a Classe Login e convoca a função getUser para alimentar o setData da Classe Model
     * @param type $idUser
     */
    private function setUser($idUser)
    {
        $user = new Login();
        $user->getUser($idUser);
    }
}
