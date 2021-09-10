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
        $id_produto = $_GET['id_produto'];
        $_SESSION['teste']= $id_produto;
        echo 'Adicionado o produto ' . $id_produto. ' ao carrinho.';
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
