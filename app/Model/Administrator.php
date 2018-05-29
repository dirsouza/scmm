<?php

namespace App\Model;

use Core\Model;
use Lib\Dao;
use App\Model\User;

class Administrator extends Model
{
    private $error = [];
    
    /**
     * Adicionar usuário Administrador
     * @param type $idUser
     */
    public function addAdministrador()
    {
        $vData = $this->verifyData();
        $vUser = $this->verifyUsuario();

        if ($vData === true && $vUser === true) {
            $user = new User();
            $user->setData($this->getValues());
            $id = $user->addUsuario();

            try {
                $sql = new Dao();
                $sql->allQuery("INSERT INTO tbadministrador (idusuario,desnome,descpf,desrg,desemail,destelefone)
                            VALUES (:IDUSUARIO,:DESNOME,:DESCPF,:DESRG,:DESEMAIL,:DESTELEFONE)", array(
                    ':IDUSUARIO' => $id,
                    ':DESNOME' => $this->getDesNome(),
                    ':DESCPF' => $this->getDesCPF(),
                    ':DESRG' => $this->getDesRG(),
                    ':DESEMAIL' => $this->getDesEmail(),
                    ':DESTELEFONE' => $this->getDesTelefone()
                ));

                $user->setUser($id);
            } catch (\PDOException $e) {
                $this->recoveryData();
                User::deleteUsuario($id);
                Model::returnError("Não foi possível Cadastrar o Administrador.<br>" . $e->getMessage(), $_SERVER['REQUEST_URI']);
            }
        } else {
            $this->recoveryData();
            $this->mergeArray($vData, $vUser);
        }
    }

    /**
     * Atualizar os dados do Administrador
     * @param type $idAdministrador
     */
    public function updateAdministrador($idUser)
    {
        $vData = $this->verifyData();
        $vAdmin = $this->verifyUpdateAdminsitrador($idUser);

        if ($vData === true && $vAdmin === true) {
            try {
                $sql = new Dao();
                $sql->allQuery("UPDATE tbadministrador SET desnome = :DESNOME,
                                                           descpf = :DESCPF,
                                                           desrg = :DESRG,
                                                           desemail = :DESEMAIL,
                                                           destelefone = :DESTELEFONE
                                WHERE idusuario = :IDUSUARIO", array(
                    ':IDUSUARIO' => $idUser,
                    ':DESNOME' => $this->getDesNome(),
                    ':DESCPF' => $this->getDesCPF(),
                    ':DESRG' => $this->getDesRG(),
                    ':DESEMAIL' => $this->getDesEmail(),
                    ':DESTELEFONE' => $this->getDesTelefone()
                ));
            } catch (\PDOException $e) {
                Model::returnError("Não foi possível Atualizar o Administrador.<br>" . $e->getMessage(), $_SERVER['REQUEST_URI']);
            }
        } else {
            $this->mergeArray($vData, $vAdmin);
        }
    }

    /**
     * Atualiza a senha do Administrador
     * @param type $idUser
     */
    public function updateSenhaAdministrador(int $idUser, string $password)
    {
        try {
            $sql = new Dao();
            $sql->allQuery("UPDATE tbusuario SET dessenha = :DESSENHA
                            WHERE idusuario = :IDUSUARIO", array(
                ':IDUSUARIO' => $idUser,
                ':DESSENHA' => password_hash($password, PASSWORD_DEFAULT)
            ));
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível Atualizar a Senha do Administrador.<br>" . $e->getMessage(), $_SERVER['REQUEST_URI']);
        }
    }

    /**
     * Exclui um usuário
     * @param type int
     */
    public function deleteAdministrador(int $idUser)
    {
        try {
            $sql = new Dao();
            $sql->allQuery("DELETE FROM tbusuario
                            WHERE idusuario = :IDUSUARIO", array(
                ':IDUSUARIO' => $idUser
            ));
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível Excluir o Administrador.<br>" . $e->getMessage());
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
            $results = $sql->allSelect("SELECT * FROM tbadministrador
                                        INNER JOIN tbusuario
                                        USING (idusuario)");

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
                                       INNER JOIN tbusuario
                                       USING (idusuario)
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

    private function mergeArray($vData, $vAdmin)
    {
        if (is_array($vData) && is_array($vAdmin)) {
            $this->errorUser(array_merge($vData, $vAdmin));
        } else {
            if (is_array($vData) && !is_array($vAdmin)) {
                $this->errorUser($vData);
            } else {
                $this->errorUser($vAdmin);
            }
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
        $result = $sql->allSelect("SELECT * FROM tbadministrador WHERE desemail = :DESEMAIL", array(
            ':DESEMAIL' => $this->getDesEmail()
        ));

        if (is_array($result) && count($result) > 0) {
            foreach ($result[0] as $key => $value) {
                switch ($key) {
                    case 'desemail':
                        if ($value === $this->getDesEmail()) $this->error[] = "Endereço de <b>E-mail</b> já existe.";
                        break;
                    case 'descpf':
                        if ($value === $this->getDesCPF()) $this->error[] = "O <b>CPF</b> informado já existe.";
                        break;
                }
            }
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
     * Verifica se o nome de Usuário ou E-mail já existem
     * Caso SIM - Retorna o resultado encontrado
     * Caso NAO - Retorna true
     */
    private function verifyUpdateAdminsitrador(int $idUser)
    {
        $sql = new Dao();
        // Obtém os dados da tabela Cliente
        $result = $sql->allSelect("SELECT * FROM tbadministrador
                                   INNER JOIN tbusuario
                                   USING (idusuario)
                                   WHERE desemail = :DESEMAIL", array(
            ':DESEMAIL' => $this->getDesEmail()
        ));
        
        if (is_array($result) && count($result) > 0) {
            foreach ($result as $key) {
                if ($key['desemail'] === $this->getDesEmail() && $key['deslogin'] !== $this->getDesLogin()) {
                    $this->error[] = "Endereço de <b>E-mail</b> já registrado para outro Usuário.";
                }
            }
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

    private function verifyData()
    {
        $error = [];

        foreach ($this->getValues() as $key => $value) {
            if (empty($value) && $key != "DesTipo" && $key != "DesConfSenha") {
                $error[] = "O campo <b>" . preg_replace('/Des/',"", $key) . "</b> não foi informado.";
            }
        }

        $result = $this->verifyCPF($this->getDesCPF());

        if ($result !== true) {
            $error[] = $result;
        }

        if (count($error) > 0) {
            return $error;
        }

        return true;
    }

    private function verifyCPF(string $cpf)
    {
        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
        
        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return "O <b>CPF</b> informado está incompleto.";
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return "O <b>CPF</b> informado não é inválido.";
        }
        
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                return "O <b>CPF</b> informado não é inválido.";
            }
        }

        return true;
    }

    private function recoveryData()
    {
        $_SESSION['restoreData'] = array(
            'desNome' => $this->getDesNome(),
            'desCPF' => $this->getDesCPF(),
            'desRG' => $this->getDesRG(),
            'desLogin' => $this->getDesLogin(),
            'desEmail' => $this->getDesEmail(),
            'desTelefone' => $this->getDesTelefone()
        );
    }
}