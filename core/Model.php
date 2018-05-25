<?php

namespace Core;

/**
 * Classe que prepara os dados tanto para consulta quanto para inserção
 * no Banco de Dados
 *
 
 */
class Model {
    //Array privada que irá receber os nomes dos campos e valores
    private $values = [];
    
    /**
     * Recebe e trata os parâmetros recebidos por getter e setter
     * @param type $name
     * @param type $arguments
     * @return type
     */
    public function __call(string $name, string $arguments) 
    {
        $method = substr($name, 0, 3); //Atribui os três primeiros caracteres a variável
        $fieldName = substr($name, 3, strlen($name)); //Atribui os caracteres restantes após os três primeiros
        
        switch ($method) {
            case "get":
                return $this->values[$fieldName]; //Retorna o nome do campo
            case "set":
                $this->values[$fieldName] = $arguments[0]; //Atribui ao Array a chave {Campo} e valor
                break;
        }
    }

    /**
     * Chama pela referência $this a função construtora __call, passando os parâmetros:
     * {"set".ucfirst($key)} para $name --"set" é concatenado ao nome da chave da array
     * para cair no caso "set" da switch; e
     * (trim($value)) para $arguments --Valor contido na chave $key da array.
     * Obs.: a função ucfirst() pega o primeiro caracter da string e a torna maúscula.
     *       a função trim() remove os espaços em branco antes e depois do valor.
     * @param type $param
     */
    public function setData(array $param) 
    {
        foreach ($param as $key => $value) {
            $this->{"set". ucfirst($key)}(trim($value));
        }
    }
    
    /**
     * Retorna os valores contidos na Array
     * @return type
     */
    public function getValues() 
    {
        return $this->values;
    }
    
    /**
     * Direciona para a página que ocorreu o erro passada por parâmetro e mostra
     * a mensagem do erro.
     * @param type $msg
     * @param type $location
     */
    public static function returnError(string $msg, string $location = '/') 
    {
        if ($location === "/") {
            $_SESSION['notify'] = array (
                'type' => 'error',
                'msg' => $msg
            );
        }

        $_SESSION['error'] = $msg;
        header("location: " . $location);
        exit;
    }
}
