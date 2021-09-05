<?php

namespace core\controllers;

use core\classes\Database;
use core\classes\Store;
use core\models\Clientes;

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
        
        // Criação e registro na db

        // Verifica se txt_senha_1 ==  txt_senha_2
        if($_POST['text_senha_1'] != $_POST['text_senha_2']){
            // as senha são diferentes
            $_SESSION['erro']= 'As senhas não estão iguais.';
            $this->novo_cliente();
            return;
        }

        $cliente = new Clientes;
        if($cliente->verificar_email_registrado($_POST['text_email'])){
            $_SESSION['erro']= 'O já existe um cliente com este e-mail.';
            $this->novo_cliente();
        }

        $purl = $cliente->registar_cliente();
        // criar um link purl
        $link_purl="http://localhost:8000/phpstore/public/?a=confirmar_email&purl=$purl";
        // enviar um email para o cliente
       
       
        // apresentar uma mensagem indicando para validar seu e-mail


       
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
