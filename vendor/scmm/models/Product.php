<?php

namespace SCMM\Models;

use SCMM\Configs\Model;
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
            if ($this->verifyProduto()) {
                $sql = new Dao();
                $sql->allQuery("INSERT INTO tbproduto (desnome,desmarca,desdescricao)
                                VALUE (:DESNOME,:DESMARCA,:DESDESCRICAO)", array(
                                    ':DESNOME' => $this->getDesNome(),
                                    ':DESMARCA' => $this->getDesMarca(),
                                    ':DESDESCRICAO' => $this->getDesDescricao()
                                ));
            } else {
                $this->restoreData();
                Model::returnError("O produto informado já está cadastrado ou estão faltando dados.", $_SERVER["REQUEST_URI"]);
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível Cadastrar o Produto.<br>".$e->getMessage(), $_SERVER['REQUEST_URI']);
        }
    }
    
    /**
     * Atualiza os dados de um produto
     * @param type $idProduct
     */
    public function updateProduto($idProduct) {
        try {
            if ($this->verifyDados()) {
                $sql = new Dao();
                $sql->allQuery("UPDATE tbproduto SET desnome = :DESNOME,
                                                    desmarca = :DESMARCA,
                                                    desdescricao = :DESDESCRICAO
                                WHERE idproduto = :IDPRODUTO", array(
                                    ':IDPRODUTO' => $idProduct,
                                    ':DESNOME' => $this->getDesNome(),
                                    ':DESMARCA' => $this->getDesMarca(),
                                    ':DESDESCRICAO' => $this->getDesDescricao()
                                ));
            } else {
                Model::returnError("Estão faltando dados.", $_SERVER["REQUEST_URI"]);
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível Atualizar o Produto.<br>".$e->getMessage(), $_SERVER['REQUEST_URI']);
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
            Model::returnError("Não foi possível Deletar o Produto.<br>".$e->getMessage(), $_SERVER['REQUEST_URI']);
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
            Model::returnError("Não foi possível recuperar os dados de Produto.<br>".$e->getMessage(), $_SERVER['REQUEST_URI']);
        }
    }
    
    /**
     * Lista um produto e retorna uma Array
     * @param type $idProduct
     * @return type Array
     */
    public static function listProdutoId($idProduct) {
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
            Model::returnError("Não foi possível recuperar os dados do Produto.<br>".$e->getMessage(), $_SERVER['REQUEST_URI']);
        }
    }

    /**
     * Verifica se o nome do produto informado já consta no banco de dados
     */
    private function verifyProduto() {
        if ($this->verifyDados()) {
            $sql = new Dao();
            $result = $sql->allSelect('SELECT * FROM tbproduto WHERE desnome = :DESNOME AND desmarca = :DESMARCA', array(
                ':DESNOME' => $this->getDesNome(),
                ':DESMARCA' => $this->getDesMarca()
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
        if (empty($this->getDesNome())) {
            return false;
        }

        if (empty($this->getDesMarca())) {
            return false;
        }

        if (empty($this->getDesDescricao())) {
            return false;
        }

        return true;
    }

    private function restoreData() {
        $_SESSION['restoreData'] = array(
            'desNome' => $this->getDesNome(),
            'desMarca' => $this->getDesMarca(),
            'desDescricao' => $this->getDesDescricao()
        );
    }
}
