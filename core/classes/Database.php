<?php

namespace core\classes;

use Exception;
use PDO;
use PDOException;

class Database
{

    private $ligacao;

    //============================================================
    //$conn = new PDO('mysql:host=localhost;dbname=meuBancoDeDados', $username, $password);
    private function ligar()
    {
        $this->ligacao = new PDO('mysql:host='.MYSQL_SERVER.';'.
            'dbname='.MYSQL_DATABASE.';' .
            'charset' . MYSQL_CHARSET,
            MYSQL_USER,
            MYSQL_PASS,
            array(PDO::ATTR_PERSISTENT => true)
        );
        // debug
        $this->ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    //============================================================
    private function desligar()
    {
        // desliga-se da base de dados
        $this->ligacao = null;
    }

    //============================================================
    // CRUD
    //============================================================
    public function select($sql, $parametros = null)
    {
        $sql = trim($sql);
        // verifica se é uma instrução select
        if(!preg_match("/^SELECT/i", $sql)){
            throw new Exception('Base de dados -> não é uma instrução SELECT.');
        }

        // liga ao db
        $this->ligar();

        $resultados = null;

        try {
            // comunicação com o db
            if (!empty($parametros)) {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute($parametros);
                $resultados = $executar->fetchAll(PDO::FETCH_CLASS);
            } else {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute();
                $resultados = $executar->fetchAll(PDO::FETCH_CLASS);
            }
        } catch (PDOException $e) {
            // caso exista erro
            return false;
        }


        // desliga-se do db
        $this->desligar();
        return $resultados;
    }
    //============================================================
    public function insert($sql, $parametros = null)
    {
        $sql = trim($sql);
        // verifica se é uma instrução select
        if(!preg_match("/^INSERT/i", $sql)){
            throw new Exception('Base de dados -> não é uma instrução INSERT.');
        }

        // Ligar ao db
        $this->ligar();

        $resultados = null;

        try {
            // comunicação com o db
            if (!empty($parametros)) {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute($parametros);
            } else {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute();
            }
        } catch (PDOException $e) {
            // caso exista erro
            return false;
        }


        // desliga-se do db
        $this->desligar();
      
    }
    //============================================================
    public function update($sql, $parametros = null)
    {
        $sql = trim($sql);
        // verifica se é uma instrução select
        if(!preg_match("/^UPDATE/i", $sql)){
            throw new Exception('Base de dados -> não é uma instrução UPDATE.');
        }

        // Ligar ao db
        $this->ligar();

        $resultados = null;

        try {
            // comunicação com o db
            if (!empty($parametros)) {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute($parametros);
            } else {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute();
            }
        } catch (PDOException $e) {
            // caso exista erro
            return false;
        }


        // desliga-se do db
        $this->desligar();
      
    }
    //============================================================
    public function delete($sql, $parametros = null)
    {
        $sql = trim($sql);
        // verifica se é uma instrução select
        if(!preg_match("/^DELETE/i", $sql)){
            throw new Exception('Base de dados -> não é uma instrução DELETE.');
        }

        // Ligar ao db
        $this->ligar();

        $resultados = null;

        try {
            // comunicação com o db
            if (!empty($parametros)) {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute($parametros);
            } else {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute();
            }
        } catch (PDOException $e) {
            // caso exista erro
            return false;
        }


        // desliga-se do db
        $this->desligar();
      
    }

    //============================================================
    // Genérica
    //============================================================
    public function statement($sql, $parametros = null)
     {
        $sql = trim($sql);
         // verifica se é uma instrução diferente da anteriores
         if(preg_match("/^DELETE|INSERT|UPDATE|DELETE/i", $sql)){
             throw new Exception('Base de dados -> instrução invàlida.');
         }
 
         // Ligar ao db
         $this->ligar();
 
         $resultados = null;
 
         try {
             // comunicação com o db
             if (!empty($parametros)) {
                 $executar = $this->ligacao->prepare($sql);
                 $executar->execute($parametros);
             } else {
                 $executar = $this->ligacao->prepare($sql);
                 $executar->execute();
             }
         } catch (PDOException $e) {
             // caso exista erro
             return false;
         }
 
 
         // desliga-se do db
         $this->desligar();
       
     }
}

/*
    CRUD
    Create  - INSERT
    Read    - SELECT
    Update  - UPDATE  
    Delete  - DELETE
*/


