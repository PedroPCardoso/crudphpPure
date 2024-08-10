<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/Database/Database.php';
Database::getInstance();
// Carrega as rotas
require_once 'api.php';

// Esta é a entrada principal do projeto
// As rotas serão processadas no arquivo `api.php`
