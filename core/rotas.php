<?php


// Exemplo : http://localhost:8000/?a=inicio

// coleção de rotas
$rotas = [
    'inicio'=>'main@index',
    'loja'=>'main@loja',

    // cliente
    'novo_cliente'=>'main@novo_cliente',
    'criar_cliente'=>'main@criar_cliente',
    'confirmar_email'=>'main@confirmar_email',
    // Login
    'login'=>'main@login',
    'login_submit'=>'main@login_submit',
    'logout'=>'main@logout',

    // carrinho
    'adicionar_carrinho'=>'carrinho@adicionar_carrinho',
    'carrinho'=>'carrinho@carrinho',
];

// define ação padrão
$acao = 'inicio';

// verifica se existe uma ação na query string
if(isset($_GET['a'])){
    // verifica se a ação existe nas rotas
    if(!key_exists($_GET['a'],$rotas )){
        $acao = 'inicio';
    }else{
         $acao = $_GET['a'];   
    }
}


if(count($_POST) > 0){
    $a = $_SERVER['REQUEST_URI'];
    $b[] = explode('=',$a);
    if(!key_exists( $b[0][1], $rotas)){
        $acao = 'inicio';
    }else{
        $acao =  $b[0][1];
    }
}


// trata a definição da rota
$partes= explode('@',$rotas[$acao]);
$controlador = 'core\\controllers\\'.ucfirst($partes[0]);
$metodo = $partes[1];

$ctr = new $controlador();
$ctr->$metodo();

