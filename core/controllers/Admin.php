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
        if(!Store::adminLogado()){
           Store::redirect('admin_login', true);
           return;
        }
        // já existe un admin logado
        
        // apresenta a pagina inicial do backoffice
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/header',
            'admin/home',
            'admin/footer',
            'admin/layouts/html_footer',
        ]);
    }
    //============================================================
    public function admin_login(){
        if(Store::adminLogado()){
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
        if(Store::adminLogado()){
            Store::redirect('inicio', true);
            return;
         }

         // valida se as informações chegaram corretamente preenchidas
         if(!isset($_POST['text_admin'])||
             !isset($_POST['text_senha']) ||
             !filter_var(trim($_POST['text_admin']),FILTER_VALIDATE_EMAIL)){
            // erro de preenchimento de formulário
            $_SESSION['erro']='login inválido';
            Store::redirect('admin_login', true);
            return;
         }
         // prepara dados para o model
         $email_admin = trim(strtolower($_POST['text_admin']));
         $senha = trim($_POST['text_senha']);

         $admin = new ModelsAdmin();
         $resultado = $admin->validar_login($email_admin, $senha);
         if(is_bool($resultado)){
            // login inválido
            $_SESSION['erro']='login invalido';
            Store::redirect('login', true);
            return;
         }else{
             if(!password_verify($senha,$resultado->senha)){
                // senha incorreta
                $_SESSION['erro']='login invalido';
                Store::redirect('login', true);
                return;
             }
             // login válido
             $_SESSION['admin']=$resultado->id_admin;
             $_SESSION['usuario']=$resultado->email;
             // redireciona para pagina inicial do backoffice
             Store::redirect('inicio', true);
         }
    }

    //============================================================
    public function lista_clientes()
    {
        echo "Lista de clientes";

    }
}