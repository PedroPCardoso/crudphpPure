<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class Database
{
    private static $instance = null;

    private function __construct()
    {
        $capsule = new Capsule;

        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => 'db', // Nome do serviço no docker-compose
            'database' => 'app_db',
            'username' => 'user',
            'password' => 'password',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
