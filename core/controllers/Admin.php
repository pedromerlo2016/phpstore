<?php

namespace core\controllers;

use core\classes\EnviarEmail;
use core\classes\Store;
use core\models\Admin as ModelsAdmin;
use core\models\Database;

class Admin
{
    //=============================================================
    // senha admin1@teste.com e admin2@teste.com
    // $2y$10$6OVgc./1NbJs/RAU8QJWXuVdB0hcDJI57KDVSC9rS7Pe8QrjQxlHC
    // senha 123456
    //=============================================================
    public function index()
    {
        //temp
        // echo password_hash('123456', PASSWORD_DEFAULT);
        // die();
        // verifica se já exite sessão aberta
        if (!Store::adminLogado()) {
            Store::redirect('admin_login', true);
            return;
        }

        // verificar se exitem encomendas com status=PENDENTES
        $admin = new ModelsAdmin();
        $total_encomendas_pendentes = $admin->total_encomendas_pendente();
        $total_encomendas_em_processamento = $admin->total_encomendas_em_processamento();

        $dados = [
            'total_encomendas_pendentes' => $total_encomendas_pendentes,
            'total_encomendas_em_processamento' => $total_encomendas_em_processamento
        ];




        // $dados =[
        //     'encomendas_pendentes'=> $encomendas_pendentes,
        // ]; 
        // já existe un admin logado
        // apresenta a pagina inicial do backoffice
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/header',
            'admin/home',
            'admin/footer',
            'admin/layouts/html_footer',
        ], $dados);
    }
    //============================================================
    public function admin_login()
    {
        if (Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }
        // apresenta a pagina de login
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/header',
            'admin/login_frm',
            'admin/footer',
            'admin/layouts/html_footer',
        ]);
    }

    //============================================================
    public function admin_login_submit()
    {
        // verifica se já exite um usuario logado
        if (Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }

        // valida se as informações chegaram corretamente preenchidas
        if (
            !isset($_POST['text_admin']) ||
            !isset($_POST['text_senha']) ||
            !filter_var(trim($_POST['text_admin']), FILTER_VALIDATE_EMAIL)
        ) {
            // erro de preenchimento de formulário
            $_SESSION['erro'] = 'login inválido';
            Store::redirect('admin_login', true);
            return;
        }
        // prepara dados para o model
        $email_admin = trim(strtolower($_POST['text_admin']));
        $senha = trim($_POST['text_senha']);

        $admin = new ModelsAdmin();
        $resultado = $admin->validar_login($email_admin, $senha);
        if (is_bool($resultado)) {
            // login inválido
            $_SESSION['erro'] = 'login invalido';
            Store::redirect('login', true);
            return;
        } else {
            if (!password_verify($senha, $resultado->senha)) {
                // senha incorreta
                $_SESSION['erro'] = 'login invalido';
                Store::redirect('login', true);
                return;
            }
            // login válido
            $_SESSION['admin'] = $resultado->id_admin;
            $_SESSION['usuario'] = $resultado->usuario;
            // redireciona para pagina inicial do backoffice
            Store::redirect('inicio', true);
        }
    }

    //============================================================
    public function admin_logout()
    {
        // faz o logout do admin na sessão

        unset($_SESSION['admin']);
        unset($_SESSION['admin_usuario']);
        Store::redirect('inicio', true);
        return;
    }

    //============================================================
    public function lista_clientes()
    {

        // verifica se já exite um usuario logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }

        // pegar alista de clientes
        $clientes = ModelsAdmin::lista_clientes();
        $dados = [
            'clientes' => $clientes
        ];


        // apresenta a pagina das encomendas
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/header',
            'admin/lista_clientes',
            'admin/footer',
            'admin/layouts/html_footer',
        ], $dados);
    }

    //============================================================
    public function detalhe_cliente()
    {
        // verifica se já exite um usuario logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }
        // verifica se exite um id de cliente 
        if(!isset($_GET['c'])){
            Store::redirect('inicio',true);
            return;
        };
       
        $id_cliente= Store::aesDesencriptar($_GET['c']);
        // testa se o id_cliente é válido
        if(empty($id_cliente)){
            Store::redirect('inicio',true);
            return;
        };


        $cliente_detalhe =  ModelsAdmin::detalhe_cliente($id_cliente);
        $total_encomendas = ModelsAdmin::total_encomendas($id_cliente);
        $dados = [
            'cliente_detalhe'=>$cliente_detalhe,
            'total_encomendas'=>$total_encomendas
        ];

         // apresenta a pagina das encomendas
         Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/header',
            'admin/detalhe_cliente',
            'admin/footer',
            'admin/layouts/html_footer',
        ], $dados);
    }

    //============================================================
    function cliente_historico_encomendas(){
        // verifica se já exite um usuario logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }
        // verifica se exite um id de cliente 
        if(!isset($_GET['c'])){
            Store::redirect('inicio',true);
            return;
        };
       
        $id_cliente= Store::aesDesencriptar($_GET['c']);
         // testa se o id_cliente é válido
         if(empty($id_cliente)){
            Store::redirect('inicio',true);
            return;
        };


        $cliente_historico_encomendas  = ModelsAdmin::cliente_historico_encomendas($id_cliente);
        $cliente= ModelsAdmin::detalhe_cliente($id_cliente);
        $dados =[
        'cliente_historico_encomendas'=>$cliente_historico_encomendas,
        'cliente'=>$cliente,
        ];
         // apresenta a pagina das encomendas
         Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/header',
            'admin/cliente_historico_encomendas',
            'admin/footer',
            'admin/layouts/html_footer',
        ], $dados);
    }

    //============================================================
    public function lista_encomendas()
    {
        // verifica se exite filtro na query STRING
        $filtros = [
            'pendente' => 'PENDENTE',
            'em_processamento' => 'EM PROCESSAMENTO',
            'cancelada' => 'CANCELADA',
            'enviada' => 'ENVIADA',
            'concluida' => 'CONCLUIDA',
        ];

        $filtro = "";
        if (isset($_GET['f'])) {
            // verifica se a variavel é uma key dos filtros
            if (key_exists($_GET['f'], $filtros)) {
                $filtro = $filtros[$_GET['f']];
            }
        }
        // carregamento dos dados
        $admin_model = new ModelsAdmin();
        $lista_encomendas = $admin_model->lista_encomendas($filtro);
        //Store::printData($lista_encomendas);
        $dados = [
            'lista_encomendas' => $lista_encomendas,
            'filtro' => $filtro,
        ];

        // apresenta a pagina das encomendas
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/header',
            'admin/lista_encomendas',
            'admin/footer',
            'admin/layouts/html_footer',
        ], $dados);
    }
}
