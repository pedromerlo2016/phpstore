<?php

namespace core\classes;

use PDO;
use PDOException;

class Database
{

    private $ligacao;

    //============================================================
    private function ligar()
    {
        $this->ligacao = new PDO(
            'mysql:' . MYSQL_SERVER . ';' .
                'host=' . MYSQL_DATABASE,
            ';' .
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
        // executa a função de pesquisa SQL
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
}

/*
    CRUD
    Create  - INSERT
    Read    - SELECT
    Update  - UPDATE  
    Delete  - DELETE
*/


