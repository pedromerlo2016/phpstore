<?php

use core\classes\Database;
use core\classes\Functions;

// Abrir ação
session_start();

// carregar o config
require_once('../config.php');

// carega todas as classes do projeto
require_once('../vendor/autoload.php');

$db =  new Database();
$clientes = $db->select("SELECT * FROM clientes");
echo '<pre>';
print_r($clientes);

/*
 carregar o config
 carregar classes
 carregar o sistema de rotas
    - mostrar a loja
    - mostrar o carrinho
    - mostrar o backoffice, etc.
 */