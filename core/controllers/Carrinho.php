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
        
        
        // adiciona/gestão da variável de SESSÂO do carrinho
        /*
        1. puxar o arry do carrinho da sessão pra o código
        2. gerir o array do carrinho
        3. recolocar o array na sessão
        */
    
        // vai busrcar o id_produto na query string
        if(!isset($_GET['id_produto'])){
            header('Location: ').BASE_URL.'index.php?a=loja';
            return;
        }
        // define o id do produto
        $id_produto = $_GET['id_produto'];

        $produtos = new Produtos();
        $resultados = $produtos->verifica_stock_produto($id_produto);
        if(!$resultados){
            header('Location: ').BASE_URL.'index.php?a=loja';
            return;
        }
      
        $carrinho = [];
        if(isset($_SESSION['carrinho'])){
            //$carrinho= $_SESSION['carrinho'];
            echo count($_SESSION['carrinho']);
            return;
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
        unset($_SESSION['carrinho']);

        // recarrega carrinho
        $this->carrinho();
        
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
