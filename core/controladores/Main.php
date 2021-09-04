<?php

namespace core\controladores;

use core\classes\Store;

class Main
{
    //============================================================
    public function index()
    {
        // apresenta a pagina inicial
        Store::Layout([
            'layouts/html_header',
            'header',
            'inicio',
            'footer',
            'layouts/html_footer',
        ]);
    }
    //============================================================
    public function loja()
    {
        // apresenta a pagina da loja
        Store::Layout([
            'layouts/html_header',
            'header',
            'loja',
            'footer',
            'layouts/html_footer',
        ]);
    }
    //============================================================
    public function novo_cliente()
    {
        // apresenta a pagina para novo cliente

        // verifica se existe um cliente logado
        if (Store::clienteLogado()) {
            $this->index();
            return;
        }

        Store::Layout([
            'layouts/html_header',
            'header',
            'criar_cliente',
            'footer',
            'layouts/html_footer',
        ]);
    }

    public function criar_cliente()
    {

        // verifica se existe um cliente logado
        if (Store::clienteLogado()) {
            $this->index();
            return;
        }

        // verifica ocorreu um submit
        if($_SERVER['REQUEST_METHOD']!='POST'){
            $this->index();
            return;
        }
        // apresenta a pagina para criar novo cliente



        var_dump($_POST);
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
