<?php

namespace core\classes;
use Exception;

class Store{

    //============================================================
    public static function Layout($estruturas , $dados=null){
        // verifica se estrutura é um array
        if(!is_array($estruturas)){
            throw new Exception("Coleção de estruturas inválidas");
        }
        // variáveis
        if(!empty($dados)&& is_array($dados)){
            extract($dados);
        }

        // apresentar as views da aplicação
        foreach($estruturas as $estrutura){
            include("../core/views/$estrutura.php");
        }
    }
    
    //============================================================
    public static function clienteLogado(){
        // verifica se existe um cliente com sessão
        return(isset($_SESSION['cliente']));
    }


}
