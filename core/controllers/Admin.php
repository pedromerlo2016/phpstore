<?php
namespace core\controllers;

use core\classes\EnviarEmail;
use core\classes\Store;
use core\models\Database;
class Admin
{
    //============================================================
    public function index()
    {
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
    public function lista_clientes()
    {
        echo "Lista de clientes";
    }
}