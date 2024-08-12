<?php

require_once 'Models/Order.php';
require_once 'Services/OrderService.php';

class OrderController
{
    private $orderService;

    public function __construct()
    {
        $this->orderService = new OrderService();
    }

    public function index()
    {
        echo json_encode(['status_code' => 200, 'data' => $this->orderService->getAllOrders()]);
    }

    public function store()
    {
        $data = json_decode(file_get_contents('php://input'), true);
       
        $order = $this->orderService->createOrder($data);
        echo json_encode(['status_code' => 201, 'data' => $order]);

    }

    public function show($id)
    {
        $order = $this->orderService->getOrderById($id);
        echo json_encode(['status_code' => 200, 'data' => $order]);
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $order = $this->orderService->updateOrder($id, $data);
        echo json_encode(['status_code' => 200, 'data' => $order]);

    }

    public function delete($id)
    {
        $this->orderService->deleteOrder($id);
        echo json_encode(['status_code' => 204, 'message' => 'Order deleted']);
    }
}
