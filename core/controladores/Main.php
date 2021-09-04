<?php

namespace core\controladores;

use core\classes\Database;
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
        
        // Criação e registro na db

        // Verifica se txt_senha_1 ==  txt_senha_2
        if($_POST['text_senha_1'] != $_POST['text_senha_2']){
            // as senha são diferentes
            $_SESSION['erro']= 'As senhas não estão iguais.';
            $this->novo_cliente();
            return;
        }


        // Verifica na db se exite cliente com mesmo e-mail
        $db = new Database();
        $parametros=[
            ':email'=>strtolower(trim($_POST['text_email'])),
        ];

        $resultado = $db->select("SELECT email FROM clientes WHERE email=:email", $parametros);

        // se o email já existe
        if(count($resultado)){
            $_SESSION['erro']= 'O já existe um cliente com este e-mail.';
            $this->novo_cliente();
            return;
        }

        // registro do novo cliente

        // criação do purl
        $purl =  Store::criarHash();
        echo $purl;
       
        // gravar dados na tabela
        $parametros =[
            ':email'=> strtolower(trim($_POST['text_email'])),
            ':senha'=> password_hash(trim($_POST['text_senha_1']), PASSWORD_DEFAULT),
            ':nome_completo'=>trim($_POST['text_nome_completo']),
            ':endereco' =>trim($_POST['text_endereco']),
            ':cidade' =>trim($_POST['text_cidade']),
            ':telefone' =>trim($_POST['text_telefone']),
            ':purl'=> $purl,
            ':ativo'=>0
        ];

        $db->insert('INSERT INTO clientes (email, senha, nome_completo,endereco, cidade, telefone, purl, ativo) VALUES(:email,:senha,:nome_completo,:endereco,:cidade,:telefone,:purl,:ativo)' , $parametros);
        
        // criar um link purl
        $link_purl="http://localhost:8000/phpstore/public/?a=confirmar_email&purl=$purl";

        // enviar um email para o cliente
        // apresentar uma mensagem indicando para validar seu e-mail


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
