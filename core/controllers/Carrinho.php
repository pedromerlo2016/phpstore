<?php

namespace core\controllers;

use core\classes\Store;
use core\models\Clientes;
use core\models\Produtos;

class Carrinho
{
    //============================================================

    public function adicionar_carrinho()
    {
        // vai busrcar o id_produto na query string
        $id_produto = $_GET['id_produto'];
        // adiciona/gestão da variável de SESSÂO do carrinho
        /*
        1. puxar o arry do carrinho da sessão pra o código
        2. gerir o array do carrinho
        3. recolocar o array na sessão
        */

        $carrinho = [];
        if(isset($_SESSION['carrinho'])){
            $carrinho= $_SESSION['carrinho'];
        }

        // adicionar o produto ao carrinho
        // caso já exista, soma mais um

        if(key_exists($id_produto, $carrinho))
        {
            // já exite o produto, Acrescenta mais uma unidade
            $carrinho[$id_produto]++;
        }else{
            // caso não exista, adiciona novo produto ao carrinho
            $carrinho[$id_produto] = 1;
        }
        // Atualiza os dados do corrinho na sessão
        $_SESSION['carrinho']= $carrinho;

        /*
        carrinho[
            [3]->2,
            [4]->1,
        ]
        */

        // devolve a resposta (número de produtos no carrinho)
        
        $total_produtos = 0;
        foreach($carrinho as $produto_quantidade){
            $total_produtos+= $produto_quantidade;
        }
        
        
        echo $total_produtos;
    }
    //============================================================
    public function limpar_carrinho(){
        // limpa o carrinho de todos os produtos

        $_SESSION['carrinho']=[];
        
    }

    //============================================================
    public function carrinho()
    {
        // apresenta a pagina do carrinho
        Store::Layout([
            'layouts/html_header',
            'header',
            'carrinho',
            'footer',
            'layouts/html_footer',
        ]);
    }
}
