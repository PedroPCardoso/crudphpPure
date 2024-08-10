<?php
class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
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

    public function __wakeup()
    {
    }
}
try {
    try {
        $db = Database::getInstance();

        // Criando a tabela users
        $db->exec("
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                first_name VARCHAR(255) NOT NULL,
                last_name VARCHAR(255) NOT NULL,
                document VARCHAR(20) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                phone_number VARCHAR(15),
                birth_date DATE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )
        ");

        // Criando a tabela orders
        $db->exec("
            CREATE TABLE IF NOT EXISTS orders (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                description TEXT NOT NULL,
                quantity INT NOT NULL,
                price DECIMAL(10, 2) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            )
        ");

        echo "Migrations ran successfully!\n";

        // Verificando se o usuário admin já existe
        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => 'admin@example.com']);
        $adminExists = $stmt->fetch();

        if (!$adminExists) {
            // Inserindo o usuário admin
            $passwordHash = password_hash('adminpassword', PASSWORD_BCRYPT);
            $stmt = $db->prepare("
                INSERT INTO users (first_name, last_name, document, email, password, phone_number, birth_date)
                VALUES (:first_name, :last_name, :document, :email, :password, :phone_number, :birth_date)
            ");
            $stmt->execute([
                'first_name' => 'Admin',
                'last_name' => 'User',
                'document' => '12345678900',
                'email' => 'admin@example.com',
                'password' => $passwordHash,
                'phone_number' => '1234567890',
                'birth_date' => '1980-01-01'
            ]);

            echo "Admin user created successfully.\n";  
        }
        else {
            echo "Admin user already exists.\n";
        }
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        exit();
    } 
} catch (PDOException $e) {
    echo "Error running migrations: " . $e->getMessage() . "\n";
}
