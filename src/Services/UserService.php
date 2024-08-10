<?php

require_once 'Database/Database.php';
require_once 'Models/User.php';

class UserService
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAllUsers()
    {
        $stmt = $this->db->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createUser($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO users (first_name, last_name, document, email, phone_number, birth_date)
            VALUES (:first_name, :last_name, :document, :email, :phone_number, :birth_date)
        ");
        $stmt->bindParam(':first_name', $data['first_name']);
        $stmt->bindParam(':last_name', $data['last_name']);
        $stmt->bindParam(':document', $data['document']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':phone_number', $data['phone_number']);
        $stmt->bindParam(':birth_date', $data['birth_date']);
        $stmt->execute();
    }

    public function getUserById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE users SET
                first_name = :first_name,
                last_name = :last_name,
                document = :document,
                email = :email,
                phone_number = :phone_number,
                birth_date = :birth_date,
                updated_at = CURRENT_TIMESTAMP
            WHERE id = :id
        ");
        $stmt->bindParam(':first_name', $data['first_name']);
        $stmt->bindParam(':last_name', $data['last_name']);
        $stmt->bindParam(':document', $data['document']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':phone_number', $data['phone_number']);
        $stmt->bindParam(':birth_date', $data['birth_date']);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function deleteUser($id)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function findUserByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function authenticateUser($email, $document)
    {
        $user = $this->findUserByEmail($email);

        if ($user && $user['document'] === $document) {
            return $user;
        }

        return null;
    }
}
