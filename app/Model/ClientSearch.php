<?php

namespace App\Model;

use Core\Model;
use Lib\Dao;

/**
 * Classe para cadastrar e controlar os filtros dos Clientes
 */
class ClientSearch extends Model
{
    public function addSearch()
    {
        $vData  = $this->verifyData();

        if ($vData === true) {
            try {
                $sql = new Dao();
                $sql->allQuery('INSERT INTO tbfiltrocliente (idcliente, desfiltro)
                                VALUES (:IDCLIENTE, :DESFILTRO)', array(
                                    ':IDCLIENTE' => $this->getIdCliente(),
                                    ':DESFILTRO' => $this->getDesFiltro()
                                ));
            } catch (\PDOException $e) {
                return "Não foi possível Cadastrar o Filtro.<br>" . $e->getMessage();
            }
        } else {
            return $this->tryError($vData);
        }

        return (int)$_SESSION[Dao::SESSION];
    }

    public function deleteSearch(int $id)
    {
        try {
            $sql = new Dao();
            $sql->allQuery("DELETE FROM tbfiltrocliente
                            WHERE idFiltroCliente = :ID", array(
                ':ID' => $id
            ));
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível Excluir o Histórico.<br>" . $e->getMessage());
        }
    }

    public static function listSearch(int $id)
    {
        try {
            $sql = new Dao();
            $result = $sql->allSelect('SELECT * FROM tbfiltrocliente WHERE idcliente = :ID', array(
                ':ID' => $id
            ));

            if (is_array($result) && count($result) > 0) {
                return $result;
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível recuperar os dados do Histórico.<br>" . $e->getMessage());
        }
    }

    public static function listSearchId(int $id)
    {
        try {
            $sql = new Dao();
            $result = $sql->allSelect('SELECT * FROM tbfiltrocliente WHERE idFiltroCliente = :ID', array(
                ':ID' => $id
            ));

            if (is_array($result) && count($result) > 0) {
                return $result[0];
            }
        } catch (\PDOException $e) {
            Model::returnError("Não foi possível recuperar os dados do Histórico.<br>" . $e->getMessage());
        }
    }

    private function verifyData()
    {
        $error = [];

        foreach ($this->getValues() as $key => $value) {
            if (empty($value)) {
                $error[] = "O campo <b>" . preg_replace('/Des/',"", $key) . "</b> não foi informado.";
            }
        }

        if (count($error) > 0) {
            return $error;
        }

        return true;
    }
    
    private function tryError(array $error)
    {
        foreach ($error as $key => $value) {
            ($key == 0) ? $msg = $value : $msg .= "<br>" . $value;
        }

        return $msg;
    }
}