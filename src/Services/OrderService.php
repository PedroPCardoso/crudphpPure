<?php

require_once 'Database/Database.php';
require_once 'Models/Order.php';

class OrderService
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllOrders()
    {
        $stmt = $this->db->prepare("SELECT * FROM orders");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createOrder($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO orders (user_id, description, quantity, price)
            VALUES (:user_id, :description, :quantity, :price)
        ");
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':quantity', $data['quantity']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->execute();
    }

    public function getOrderById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateOrder($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE orders SET
                description = :description,
                quantity = :quantity,
                price = :price,
                updated_at = CURRENT_TIMESTAMP
            WHERE id = :id
        ");
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':quantity', $data['quantity']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function deleteOrder($id)
    {
        $stmt = $this->db->prepare("DELETE FROM orders WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}
