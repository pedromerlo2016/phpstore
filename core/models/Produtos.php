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
        $categorias = $this->lista_categorias();
        $sql = "SELECT * FROM produtos ";
        $sql .= "WHERE visivel = 1 ";
        if (in_array($categoria, $categorias)){
            $sql.= "AND categoria = '$categoria'";
        }
        
        $produtos = $db->select($sql);
        return $produtos;
    }

    //============================================================
    public function lista_categorias(){
       // buscar todas as categorias dos produtos disponivéis na base de dados  
       $db = new Database();
       $sql = "SELECT DISTINCT categoria FROM produtos ";
       $resultados = $db->select($sql);
       $categorias =[];
       foreach($resultados as $resultado){
           array_push($categorias, $resultado->categoria);
       }
       return $categorias;
    }
}
