<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/Database/Database.php';
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Authorization');
if (@$_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    die();
}


Database::getInstance();
// Carrega as rotas
require_once 'api.php';

// Esta é a entrada principal do projeto
// As rotas serão processadas no arquivo `api.php`
