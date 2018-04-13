<?php

namespace SCMM\Controllers;

use SCMM\Models\Model;
use SCMM\Configs\Dao;

/**
 * Classe para cadastrar e controlar produtos
 *
 * @author Aluno
 */
class Product extends Model {
    /**
     * Adiciona um novo Produto
     */
    public function addProduto() {
        try {
            $sql = new Dao();
            $sql->allQuery("INSERT INTO tbproduto (desnome,desdescricao)
                            VALUE (:DESDENOME,:DESDESCRICAO)", array(
                                ':DESNOME' => $this->getDesNome(),
                                ':DESDESCRICAO' => $this->getDesDescricao()
                            ));
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível Cadastrar o Produto.<br>".\PDOException($e->getMessage()), "/scmm/admin/product/create");
        }
    }
    
    /**
     * Atualiza os dados de um produto
     * @param type $idProduct
     */
    public function updateProduto($idProduct) {
        try {
            $sql = new Dao();
            $sql->allQuery("UPDATE tbproduto SET desnome = :DESNOME,
                                                 desdescricao = :DESDESCRICAO
                            WHERE idproduto = :IDPRODUTO", array(
                                ':IDPRODUTO' => $idProduct,
                                ':DESNOME' => $this->getDesNome(),
                                ':DESDESCRICAO' => $this->getDesDescricao()
                            ));
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível Atualizar o Produto.<br>".\PDOException($e->getMessage()), "/scmm/admin/product/update/".$idProduct);
        }
    }
    
    /**
     * Exclui um produto
     * @param type $idProduct
     */
    public function deleteProduto($idProduct) {
        try {
            $sql = new Dao();
            $sql->allQuery("DELETE FROM tbproduto
                            WHERE idproduto = :IDPRODUTO", array(
                                ':IDPRODUTO' => $idProduct
                            ));
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível Deletar o Produto.<br>".\PDOException($e->getMessage()), "/scmm/admin/product");
        }
    }
    
    /**
     * Lista todos os Produtos e retorna uma Array
     * @return type Array
     */
    public static function listProdutos() {
        try {
            $sql = new Dao();
            $results = $sql->allSelect("SELECT * FROM tbproduto");

            if (is_array($results) && count($results) > 0) {
                return $results;
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível recuperar os dados de Produto.<br>".\PDOException($e->getMessage()), "/scmm/admin/product");
        }
    }
    
    /**
     * Lista um produto e retorna uma Array
     * @param type $idProduct
     * @return type Array
     */
    public static function listPrudotoId($idProduct) {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT * FROM tbproduto
                                        WHERE idproduto = :IDPRODUTO", array(
                                            ':IDPRODUTO' => $idProduct
                                        ));

            if (is_array($result) && count($result) > 0) {
                return $result;
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível recuperar os dados do Produto.<br>".\PDOException($e->getMessage()), "/scmm/admin/product/update/".$idProduct);
        }
    }
}
