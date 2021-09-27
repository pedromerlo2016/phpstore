<?php


// Exemplo : http://localhost:8000/?a=inicio

// coleção de rotas
$rotas = [

    'inicio'=>'admin@index',
    // admin   
    'admin_login'=>'admin@admin_login',
    'admin_login_submit'=>'admin@admin_login_submit',
    'admin_logout'=>'admin@admin_logout',

    // clientes
    'lista_clientes'=>'admin@lista_clientes',
    'detalhe_cliente'=>'admin@detalhe_cliente',
    'cliente_historico_encomendas'=>'admin@cliente_historico_encomendas',
  
    // encomendas
    'lista_encomendas'=>'admin@lista_encomendas',
    'detalhe_encomenda'=>'admin@detalhe_encomenda',
    'encomenda_alterar_status'=>'admin@encomenda_alterar_status',
    'criar_pdf_encomenda'=> 'admin@criar_pdf_encomenda',
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

