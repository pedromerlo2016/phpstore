<?php

use core\classes\Database;
use core\classes\Store;

// Abrir ação
session_start();

// carega todas as classes do projeto
require_once('../vendor/autoload.php');

// carrega o sistemas de rotas
require_once('../core/rotas.php');
