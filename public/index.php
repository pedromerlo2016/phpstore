<?php

use core\classes\Database;
use core\classes\Functions;

// Abrir ação
session_start();

// carregar o config
require_once('../config.php');

// carega todas as classes do projeto
require_once('../vendor/autoload.php');

/*
 carregar o config
 carregar classes
 carregar o sistema de rotas
    - mostrar a loja
    - mostrar o carrinho
    - mostrar o backoffice, etc.
 */