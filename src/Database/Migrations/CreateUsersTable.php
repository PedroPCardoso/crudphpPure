<?php

class CreateUsersTable
{
    public function up($db)
    {
        try {
            // Executar a query de criação da tabela
            $db->exec("
                CREATE TABLE IF NOT EXISTS users (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    first_name VARCHAR(255) NOT NULL,
                    last_name VARCHAR(255) NOT NULL,
                    document VARCHAR(20) NOT NULL,
                    email VARCHAR(255) NOT NULL UNIQUE,
                    phone_number VARCHAR(15),
                    birth_date DATE,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                )
            ");
            echo "Table 'users' created successfully.\n";
        } catch (PDOException $e) {
            echo "Error creating table 'users': " . $e->getMessage() . "\n";
        }
    }
}
