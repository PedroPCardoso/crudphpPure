<?php

require_once 'Models/Order.php';
require_once 'Services/OrderService.php';

class OrderController
{
    /**
     * @var OrderService
     */
    private $orderService;

    /**
     * Construtor da classe OrderController.
     */
    public function __construct()
    {
        $this->orderService = new OrderService();
    }

    /**
     * Retorna todos os pedidos.
     *
     * @return void
     */
    public function index(): void
    {
        $user_id = $_GET['user_id'] ?? null;
        $orders = $this->orderService->getAllOrders($user_id);
        echo json_encode(['status_code' => 200, 'data' => $orders]);
    }

    /**
     * Cria um novo pedido.
     *
     * @return void
     */
    public function store(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $order = $this->orderService->createOrder($data);
        echo json_encode(['status_code' => 201, 'data' => $order]);
    }

    /**
     * Exibe os detalhes de um pedido específico.
     *
     * @param int $id ID do pedido.
     * @return void
     */
    public function show(int $id): void
    {
        $order = $this->orderService->getOrderById($id);
        echo json_encode(['status_code' => 200, 'data' => $order]);
    }

    /**
     * Atualiza os detalhes de um pedido específico.
     *
     * @param int $id ID do pedido.
     * @return void
     */
    public function update(int $id): void
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $order = $this->orderService->updateOrder($id, $data);
        echo json_encode(['status_code' => 200, 'data' => $order]);
    }

    /**
     * Exclui um pedido específico.
     *
     * @param int $id ID do pedido.
     * @return void
     */
    public function delete(int $id): void
    {
        $this->orderService->deleteOrder($id);
        echo json_encode(['status_code' => 204, 'message' => 'Order deleted']);
    }
}
