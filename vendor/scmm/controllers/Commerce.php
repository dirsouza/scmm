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
            $sql = new Dao();
            $sql->allQuery("INSERT INTO tbcomercio (desnome,descep,desrua,desbairro)
                            VALUES (:DESNOME,:DESCEP,:DESRUA,:DESBAIRRO)", array(
                                ':DESNOME' => $this->getDesNome(),
                                ':DESCEP' => $this->getDesCEP(),
                                ':DESRUA' => $this->getDesRua(),
                                ':DESBAIRRO' => $this->getDesBairro()
                            ));
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível Cadastrar o Comércio.<br>".\PDOException($e->getMessage()), "/scmm/registration/commerce/create");
        }
    }
    
    /**
     * Atualiza os dados de um comércio
     * @param type $idCommerce
     */
    public function updateComercio($idCommerce) {
        try {
            $sql = new Dao();
            $sql->allQuery("UPDATE tbcomercio SET desnome = :DESNOME,
                                                  descep = :DESCEP,
                                                  desrua = :DESRUA,
                                                  desbairro = :DESBAIRRO
                            WHERE idcomercio = :IDCOMERCIO", array(
                                ':IDCOMERCIO' => $idCommerce,
                                ':DESNOME' => $this->getDesNome(),
                                ':DESCEP' => $this->getDesCEP(),
                                ':DESRUA' => $this->getDesRua(),
                                ':DESBAIRRO' => $this->getDesBairro()
                            ));
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
}