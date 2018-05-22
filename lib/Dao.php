<?php

namespace Lib;

use Core\Model;

/**
 * Classe de conexão com o Banco de Dados
 *
 
 */
class Dao extends Model {
    //Dados do Servidor
    const HOSTNAME  = "localhost";
    const USERNAME  = "root";
    const PASSWORD  = "root";
    const DBNAME    = "db_scmm";
    
    //Constante que recebe o último ID em sessão
    const SESSION = "lastID";
    
    //Variável privada que recebe a conexão com o banco de dados
    private $conn;
    
    /**
     * Construtor da conexão
     */
    public function __construct()
    {
        try {
            $this->conn = new \PDO("mysql:dbname=" . Dao::DBNAME . ";host=" . Dao::HOSTNAME, Dao::USERNAME, Dao::PASSWORD, array(
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            ));
        } catch (\PDOException $e) {
            Model::returnError($e->getMessage(), $_SERVER['REQUEST_URI']);
        }
    }
    
    /**
     * Seta os parametrôs do array {Campo e Valor}
     * @param type $statement
     * @param type $parameters
     */
    private function setParameters($statement, $parameters = array())
    {
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
    private function bindParameter($statement, $key, $value)
    {
        $statement->bindParam($key, $value);
    }
    
    /**
     * Insere os dados
     * @param type $rawQuery
     * @param type $parameters
     * @throws \PDOException
     */
    public function allQuery($rawQuery, $parameters = array())
    {
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare($rawQuery);
            $this->setParameters($stmt, $parameters);
            $stmt->execute();
            $_SESSION[Dao::SESSION] = $this->conn->lastInsertId();
            $this->conn->commit();
        } catch (\PDOException $e) {
            $this->conn->rollBack();
            Model::returnError($e->getMessage(), "/");
        }
    }
    
    /**
     * Consulta o banco de dados retornando uma Array com
     * associação dos campos
     * @param type $rawQuery
     * @param type $parameters
     * @throws \PDOException
     */
    public function allSelect($rawQuery, $parameters = array())
    {
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare($rawQuery);
            $this->setParameters($stmt, $parameters);
            $stmt->execute();
            $this->conn->commit();
        } catch (\PDOException $e) {
            $this->conn->rollBack();
            Model::returnError($e->getMessage(), "/");
        }
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
