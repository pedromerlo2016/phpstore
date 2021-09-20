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
        // 


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
    public function lista_clientes()
    {
        echo "Lista de clientes";
    }
}