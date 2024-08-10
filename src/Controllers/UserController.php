<?php

require_once 'Models/User.php';
require_once 'Services/UserService.php';

class UserController
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function index()
    {
        echo json_encode($this->userService->getAllUsers());
    }

    public function store()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->userService->createUser($data);
    }

    public function show($id)
    {
        echo json_encode($this->userService->getUserById($id));
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->userService->updateUser($id, $data);
    }

    public function delete($id)
    {
        $this->userService->deleteUser($id);
    }
}
