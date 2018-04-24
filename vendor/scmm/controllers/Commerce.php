<?php

namespace SCMM\Controllers;

use SCMM\Models\Model;
use SCMM\Configs\Dao;

/**
 * Classe para cadastrar e controlar os Comércios
 *
 * @author Aluno
 */
class Commerce extends Model {
    /**
     * Adiciona um novo comércio
     */
    public function addComercio() {
        try {
            if ($this->verifyComercio()) {
                $sql = new Dao();
                $sql->allQuery("INSERT INTO tbcomercio (desnome,descep,desrua,desbairro)
                                VALUES (:DESNOME,:DESCEP,:DESRUA,:DESBAIRRO)", array(
                                    ':DESNOME' => trim($this->getDesNome()),
                                    ':DESCEP' => trim($this->getDesCEP()),
                                    ':DESRUA' => trim($this->getDesRua()),
                                    ':DESBAIRRO' => trim($this->getDesBairro())
                                ));
            } else {
                $this->restoreData();
                Model::returnError("O Comércio informado já encontra-se cadastrado ou estão faltando dados.", $_SERVER["REQUEST_URI"]);
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível Cadastrar o Comércio.<br>".\PDOException($e->getMessage()), $_SERVER["REQUEST_URI"]);
        }
    }
    
    /**
     * Atualiza os dados de um comércio
     * @param type $idCommerce
     */
    public function updateComercio($idCommerce) {
        try {
            if ($this->verifyDados()) {
                $sql = new Dao();
                $sql->allQuery("UPDATE tbcomercio SET desnome = :DESNOME,
                                                    descep = :DESCEP,
                                                    desrua = :DESRUA,
                                                    desbairro = :DESBAIRRO
                                WHERE idcomercio = :IDCOMERCIO", array(
                                    ':IDCOMERCIO' => $idCommerce,
                                    ':DESNOME' => trim($this->getDesNome()),
                                    ':DESCEP' => trim($this->getDesCEP()),
                                    ':DESRUA' => trim($this->getDesRua()),
                                    ':DESBAIRRO' => trim($this->getDesBairro())
                                ));
            } else {
                Model::returnError("Algum campo não foi informado.", $_SERVER["REQUEST_URI"]);
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível Atualizar o Comércio.<br>".\PDOException($e->getMessage()), "/scmm/registration/commerce/update/".$idCommerce);
        }
    }
    
    /**
     * Exclui um comércio
     * @param type $idCommerce
     */
    public function deleteComercio($idCommerce) {
        try {
            $sql = new Dao();
            $sql->allQuery("DELETE FROM tbcomercio
                            WHERE idcomercio = :IDCOMERCIO", array(
                                ':IDCOMERCIO' => $idCommerce
                            ));
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível Excluir o Comércio.<br>".\PDOException($e->getMessage()), "/scmm/registration/commerce");
        }
    }
    
    /**
     * Lista todos os Comércios e retorna uma Array
     * @return type Array
     */
    public static function listComercios() {
        try {
            $sql = new Dao();
            $results = $sql->allSelect("SELECT * FROM tbcomercio");

            if (is_array($results) && count($results) > 0) {
                return $results;
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível recuperar os dados de Comércio.<br>".\PDOException($e->getMessage()), "/scmm/registration/commerce");
        }
    }
    
    /**
     * Lista um comercio e retorna uma Array
     * @param type $idCommerce
     * @return type Array
     */
    public static function listComercioId($idCommerce) {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT * FROM tbcomercio
                                       WHERE idcomercio = :IDCOMERCIO", array(
                                            ':IDCOMERCIO' => $idCommerce
                                        ));

            if (is_array($result) && count($result) > 0) {
                return $result;
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível recuperar os dados do Comércio.<br>".\PDOException($e->getMessage()), "/scmm/registration/commerce/update/".$idCommerce);
        }
    }

    /**
     * Verifica se o nome do comércio informado já consta no banco de dados
     */
    private function verifyComercio() {
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
    private function verifyDados() {
        if (empty(trim($this->getDesNome()))) {
            return false;
        }

        if (empty(trim($this->getDesCEP()))) {
            return false;
        }

        if (empty(trim($this->getDesRua()))) {
            return false;
        }

        if (empty(trim($this->getDesBairro()))) {
            return false;
        }

        return true;
    }

    private function restoreData() {
        $_SESSION['restoreData'] = array(
            'desNome' => trim($this->getDesNome()),
            'desCEP' => trim($this->getDesCEP()),
            'desRua' => trim($this->getDesRua()),
            'desBairro' => trim($this->getDesBairro())
        );
    }
}