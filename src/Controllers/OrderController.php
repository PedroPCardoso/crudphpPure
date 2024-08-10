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
        echo json_encode($this->orderService->getAllOrders());
    }

    public function store()
    {
        echo json_encode($this->orderService->createOrder($_POST));
    }

    public function show($id)
    {
        echo json_encode($this->orderService->getOrderById($id));
    }

    public function update($id)
    {

        $data = json_decode(file_get_contents('php://input'), true);
        
        $this->orderService->updateOrder($id, $data);
    }

    public function delete($id)
    {
        $this->orderService->deleteOrder($id);
    }
}
