<?php

require_once 'Models/Order.php';

class OrderService
{
    public function __construct()
    {
        Database::getInstance();
    }

    /**
     * Retorna todos os pedidos.
     *
     * @return array
     */
    public function getAllOrders(int $id=null): array
    {
        if($id) {
            return Order::where('user_id', $id)->get()->toArray();
        }
        return Order::all()->toArray();
    }

    /**
     * Cria um novo pedido.
     *
     * @param array $data Dados para criar um novo pedido.
     * @return array
     */
    public function createOrder(array $data): array
    {
        return Order::create($data)->toArray();
    }

    /**
     * Retorna um pedido pelo ID.
     *
     * @param int $id ID do pedido.
     * @return array|null
     */
    public function getOrderById(int $id): ?array
    {
        $order = Order::find($id);
        return $order ? $order->toArray() : null;
    }

    /**
     * Atualiza um pedido pelo ID.
     *
     * @param int $id ID do pedido.
     * @param array $data Dados atualizados do pedido.
     * @return array|null
     */
    public function updateOrder(int $id, array $data): ?array
    {
        $order = Order::find($id);
        if ($order) {
            $order->update($data);
            return $order->toArray();
        }
        return null;
    }

    /**
     * Deleta um pedido pelo ID.
     *
     * @param int $id ID do pedido.
     * @return void
     */
    public function deleteOrder(int $id): void
    {
        $order = Order::find($id);
        if ($order) {
            $order->delete();
        }
    }
}
