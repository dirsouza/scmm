<?php

namespace App\Model;

use Core\Model;
use Lib\Dao;

/**
 * Classe para cadastrar e controlar os Comércios
 */
class Commerce extends Model
{
    /**
     * Adiciona um novo comércio
     */
    public function addComercio()
    {
        try {
            if ($this->verifyComercio()) {
                $sql = new Dao();
                $sql->allQuery("CALL sp_add_comercio (:DESNOME,:DESCEP,:DESRUA,:DESBAIRRO)", array(
                    ':DESNOME' => $this->getDesNome(),
                    ':DESCEP' => $this->getDesCEP(),
                    ':DESRUA' => $this->getDesRua(),
                    ':DESBAIRRO' => $this->getDesBairro()
                ));
            } else {
                $this->restoreData();
                Model::returnError("O Comércio informado já encontra-se cadastrado ou estão faltando dados.", $_SERVER["REQUEST_URI"]);
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível Cadastrar o Comércio.<br>" . $e->getMessage(), $_SERVER["REQUEST_URI"]);
        }
    }

    /**
     * Atualiza os dados de um comércio
     * @param type $idComercio
     */
    public function updateComercio($idComercio)
    {
        try {
            if ($this->verifyDados()) {
                $sql = new Dao();
                $sql->allQuery("CALL sp_update_comercio (:IDCOMERCIO,:DESCEP,:DESRUA,:DESBAIRRO)", array(
                    ':IDCOMERCIO' => $idComercio,
                    ':DESCEP' => $this->getDesCEP(),
                    ':DESRUA' => $this->getDesRua(),
                    ':DESBAIRRO' => $this->getDesBairro()
                ));
            } else {
                Model::returnError("Algum campo não foi informado.", $_SERVER["REQUEST_URI"]);
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível Atualizar o Comércio.<br>" . $e->getMessage(), $_SERVER['REQUEST_URI']);
        }
    }

    /**
     * Exclui um comércio
     * @param type $idComercio
     */
    public function deleteComercio($idComercio)
    {
        try {
            $sql = new Dao();
            $sql->allQuery("DELETE FROM tbcomercio
                            WHERE idcomercio = :IDCOMERCIO", array(
                ':IDCOMERCIO' => $idComercio
            ));
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível Excluir o Comércio.<br>" . $e->getMessage(), $_SERVER['REQUEST_URI']);
        }
    }

    /**
     * Lista todos os Comércios e retorna uma Array
     * @return type Array
     */
    public static function listComercios()
    {
        try {
            $sql = new Dao();
            $results = $sql->allSelect("SELECT * FROM vw_comercios");

            if (is_array($results) && count($results) > 0) {
                return $results;
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível recuperar os dados de Comércio.<br>" . $e->getMessage(), $_SERVER['REQUEST_URI']);
        }
    }

    /**
     * Lista um comercio e retorna uma Array
     * @param type $idComercio
     * @return type Array
     */
    public static function listComercioId($idComercio)
    {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT * FROM vw_comercios
                                        WHERE idcomercio = :IDCOMERCIO", array(
                ':IDCOMERCIO' => $idComercio
            ));

            if (is_array($result) && count($result) > 0) {
                return $result;
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível recuperar os dados do Comércio.<br>" . $e->getMessage(), $_SERVER['REQUEST_URI']);
        }
    }

    /**
     * Busca o Endereço com base no CEP passado por parâmetro
     * @param type $cep
     */
    public static function getCep($cep)
    {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT * FROM tbbairro WHERE descep = :DESCEP", array(
                ':DESCEP' => $cep
            ));

            if (is_array($result) && count($result) > 0) {
                return $result[0];
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível recuperar os dados de Bairros.<br>" . $e->getMessage(), $_SERVER['REQUEST_URI']);
        }
    }

    /**
     * Verifica se o nome do comércio informado já consta no banco de dados
     */
    private function verifyComercio()
    {
        if ($this->verifyDados()) {
            $sql = new Dao();
            $result = $sql->allSelect('SELECT * FROM tbcomercio WHERE desnome = :DESNOME', array(
                ':DESNOME' => $this->getDesNome()
            ));

            if (is_array($result) && count($result) > 0) {
                return false;
            }
        } else {
            return false;
        }

        return true;
    }

    /**
     * Verifica se todos os dados existem e se não foi passado em branco
     * -- trim() = remove espaços antes e depois da string
     * -- empty() = verifica se valor é vazio
     */
    private function verifyDados()
    {
        if (empty($this->getDesNome())) {
            return false;
        }

        if (empty($this->getDesCEP())) {
            return false;
        }

        if (empty($this->getDesRua())) {
            return false;
        }

        if (empty($this->getDesBairro())) {
            return false;
        }

        return true;
    }

    private function restoreData()
    {
        $_SESSION['restoreData'] = array(
            'desNome' => $this->getDesNome(),
            'desCEP' => $this->getDesCEP(),
            'desRua' => $this->getDesRua(),
            'desBairro' => $this->getDesBairro()
        );
    }
}