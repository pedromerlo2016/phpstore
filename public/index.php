<?php

use core\classes\Database;
use core\classes\Functions;

// Abrir ação
session_start();

// carregar o config
require_once('../config.php');

// carega todas as classes do projeto
require_once('../vendor/autoload.php');

// carrega o sistemas de rotas
require_once('../core/rotas.php');