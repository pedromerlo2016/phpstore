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
        echo 'Backoffice da loja';
    }

    //============================================================
    public function lista_clientes()
    {
        echo "Lista de clientes";
    }
}