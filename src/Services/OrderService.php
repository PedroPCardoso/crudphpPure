<?php

require_once 'Models/Order.php';

class OrderService
{
    public function __construct()
    {
        Database::getInstance(); // Certifique-se de que o Eloquent está configurado
    }

    public function getAllOrders()
    {
        return Order::all(); // Retorna todos os pedidos
    }

    public function createOrder($data)
    {
        return Order::create($data); // Cria um novo pedido
    }

    public function getOrderById($id)
    {
        return Order::find($id); 
    }

    public function updateOrder($id, $data)
    {
        $order = Order::find($id); // Encontra o pedido
        if ($order) {
            $order->update($data); // Atualiza os dados do pedido
            return $order->toArray();
        }
    }

    public function deleteOrder($id)
    {
        $order = Order::find($id); // Encontra o pedido
        if ($order) {
            $order->delete(); // Deleta o pedido
        }
    }
}
