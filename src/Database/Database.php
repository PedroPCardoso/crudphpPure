<?php

class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        // Usar o nome do serviço definido no Docker Compose
        $dsn = 'mysql:host=db;dbname=app_db';
        $username = 'user';
        $password = 'password';

        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            exit();
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance->pdo;
    }

    // Se você precisar do método __wakeup, defina-o como público
    public function __wakeup()
    {
        // lógica para o método __wakeup, se necessário
    }
}
