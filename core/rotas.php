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

    // Perfil
    'perfil'=>'main@perfil',
    'alterar_dados_pessoais'=>'main@alterar_dados_pessoais',
    'alterar_dados_pessoais_submit'=>'main@alterar_dados_pessoais_submit',
    'alterar_password'=>'main@alterar_password',
    'alterar_password_submit'=>'main@alterar_password_submit',
    // Historico encomendas
    'historico_encomendas'=>'main@historico_encomendas',
    'detalhe_encomenda'=> 'main@historico_encomendas_detalhe',
    // carrinho
    'adicionar_carrinho'=>'carrinho@adicionar_carrinho',
    'carrinho'=>'carrinho@carrinho',
    'limpar_carrinho'=>'carrinho@limpar_carrinho',
    'remover_produto_carrinho'=>'carrinho@remover_produto_carrinho',
    'finalizar_encomenda'=>'carrinho@finalizar_encomenda',
    'finalizar_encomenda_resumo'=>'carrinho@finalizar_encomenda_resumo',
    'residencia_alternativa' => 'carrinho@residencia_alternativa',
    'confirmar_encomenda' =>'carrinho@confirmar_encomenda'
    //
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

