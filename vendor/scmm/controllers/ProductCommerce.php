<?php

namespace SCMM\Controllers;

use SCMM\Models\Model;
use SCMM\Configs\Dao;

/**
 * Classe para cadastrar e controlar os preços dos Produtos amarrados a um comércio
 *
 * @author --diogo--
 */
class ProductCommerce extends Model {
    
    /**
     * Adiciona o vinculo Comercio, Produto e Preço
     */
    public function addProdutoComercio() {
        try {
            $sql = new Dao();
            $sql->allQuery("INSERT INTO tbprodutocomercio (idcomercio,idproduto,despreco) 
                            VALUES (:IDCOMERCIO,:IDPRODUTO,:DESPRECO)", array(
                                ':IDCOMERCIO' => $this->getIdComercio(),
                                ':IDPRODUTO' => $this->getIdProduto(),
                                ':DESPRECO' => $this->getDesPreco()
                            ));
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível Cadastrar o vinculo de Produto e Comércio.<br>".\PDOException($e->getMessage()), "/scmm/admin/product_commerce/create");
        }                
    }
    
    /**
     * Atualiza o vinculo Comercio, Produto e Preço
     * @param type $idProdutoComercio
     */
    public function updateProdutoComercio($idProdutoComercio) {
        try {
            $sql = new Dao();
            $sql->allQuery("UPDATE tbprodutocomercio SET idcomercio = :IDCOMERCIO,
                                                         idproduto = :IDPRODUTO,
                                                         despreco = :DESPRECO
                            WHERE idProdutoComercio = :IDPRODUTOCOMERCIO", array(
                                ':IDPRODUTOCOMERCIO' => $idProdutoComercio,
                                ':IDCOMERCIO' => $this->getIdComercio(),
                                ':IDPRODUTO' => $this->getIdProduto(),
                                ':DESPRECO' => $this->getDesPreco()
                            ));
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível Atualizar o vinculo de Produto e Comércio.<br>".\PDOException($e->getMessage()), "/scmm/admin/product_commerce/update/".$idProdutoComercio);
        } 
    }
    
    /**
     * Exclui um vinculo entre Comercio e Produto
     * @param type $idProdutoComercio
     */
    public function deleteProdutoComercio($idProdutoComercio) {
        try {
            $sql = new Dao();
            $sql->allQuery("DELETE FROM tbprodutocomercio
                            WHERE idProdutoComercio = :IDPRODUTOCOMERCIO", array(
                                ':IDPRODUTOCOMERCIO' => $idProdutoComercio
                            ));
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível Deletar o vinculo de Produto e Comércio.<br>".\PDOException($e->getMessage()), "/scmm/admin/product_commerce");
        }
    }
    
    /**
     * Lista todos os Produtos e Comercios vinculados e retorna um Array
     * @return type Array
     */
    public static function listProdutosComercios() {
        try {
            $sql = new Dao();
            $results = $sql->allSelect("SELECT a.idProdutoComercio,
                                               b.idproduto, 
                                               b.desnome AS 'desproduto',
                                               c.idcomercio, 
                                               c.desnome AS 'descomercio',
                                               a.despreco
                                        FROM tbprodutocomercio a
                                        INNER JOIN tbproduto b
                                        USING (idproduto)
                                        INNER JOIN tbcomercio c
                                        USING (idcomercio)
                                        ORDER BY a.idProdutoComercio ASC");

            if (is_array($results) && count($results) > 0) {
                return $results;
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível Listar os Produto e Comércio.<br>".\PDOException($e->getMessage()), "/scmm/admin/product_commerce");
        }
    }
    
    /**
     * Lista um Produto e Comercio vinculado e retorna um Array para atualização
     * @return type Array
     */
    public static function listProdutosComerciosId($idProdutoComercio) {
        try {
            $sql = new Dao();
            $results = $sql->allSelect("SELECT b.idproduto, 
                                               b.desnome AS 'desproduto',
                                               c.idcomercio, 
                                               c.desnome AS 'descomercio',
                                               a.despreco
                                        FROM tbprodutocomercio a
                                        INNER JOIN tbproduto b
                                        USING (idproduto)
                                        INNER JOIN tbcomercio c
                                        USING (idcomercio)
                                        WHERE idProdutoComercio = :IDPRODUTOCOMERCIO", array(
                                            ':IDPRODUTOCOMERCIO' => $idProdutoComercio
                                        ));

            if (is_array($results) && count($results) > 0) {
                return $results;
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível Listar o Produto e Comércio.<br>".\PDOException($e->getMessage()), "/scmm/admin/product_commerce/update/".$idProdutoComercio);
        }
    }
}