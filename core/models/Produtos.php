<?php

namespace core\models;

use core\classes\Database;
use core\classes\Store;

class Produtos
{
    //============================================================
    public function lista_produtos_disponiveis($categoria){
        // buscar todas as informações dos produtos disponivéis na base de dados 
        $db = new Database();
        $sql = "SELECT * FROM produtos ";
        $sql .= "WHERE visivel = 1 ";
        if ($categoria=='homem' || $categoria=='mulher'){
            $sql.= "AND categoria = '$categoria'";
        }
        
        $produtos = $db->select($sql);
        return $produtos;

    }

}
