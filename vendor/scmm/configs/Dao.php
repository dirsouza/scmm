<?php

namespace SCMM\Configs;

use SCMM\Models\Model;

/**
 * Classe de conexão com o Banco de Dados
 *
 * @author --diogo--
 */
class Dao extends Model {
    //Dados do Servidor
    const HOSTNAME = "localhost";
    const USERNAME = "root";
    const PASSWORD = "root";
    const DBNAME = "db_scmm";
    
    //Constante que recebe o último ID em sessão
    const SESSION = "lastID";
    
    //Variável privada que recebe a conexão com o banco de dados
    private $conn;
    
    /**
     * Construtor da conexão
     */
    public function __construct() {
        $this->conn = new \PDO("mysql:dbname=".Dao::DBNAME.";host=".Dao::HOSTNAME, Dao::USERNAME, Dao::PASSWORD);
        $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
    }
    
    /**
     * Seta os parametrôs do array {Campo e Valor}
     * @param type $statement
     * @param type $parameters
     */
    private function setParameters($statement, $parameters = array()) {
        foreach ($parameters as $key => $value) {
            $this->bindParameter($statement, $key, $value);
        }
    }
    
    /**
     * Liga os Campos aos valores para inserção no banco de dados
     * @param type $statement
     * @param type $key
     * @param type $value
     */
    private function bindParameter($statement, $key, $value) {
        $statement->bindParam($key, $value);
    }
    
    /**
     * Insere os dados
     * @param type $rawQuery
     * @param type $parameters
     * @throws \PDOException
     */
    public function allQuery($rawQuery, $parameters = array()) {
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare($rawQuery);
            $this->setParameters($stmt, $parameters);
            $stmt->execute();
            $_SESSION[Dao::SESSION] = $this->conn->lastInsertId();
            $this->conn->commit();
        } catch (\PDOException $e) {
            $this->conn->rollBack();
            return \PDOException($e->getMessage());
        }
    }
    
    /**
     * Consulta o banco de dados retornando uma Array com
     * associação dos campos
     * @param type $rawQuery
     * @param type $parameters
     * @throws \PDOException
     */
    public function allSelect($rawQuery, $parameters = array())//:array
    {
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare($rawQuery);
            $this->setParameters($stmt, $parameters);
            $stmt->execute();
            $this->conn->commit();
        } catch (\PDOException $e) {
            $this->conn->rollBack();
            return \PDOException($e->getMessage());
        }
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
