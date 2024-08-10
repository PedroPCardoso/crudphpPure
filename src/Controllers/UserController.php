<?php

require_once __DIR__ . '/../Services/UserService.php';

class UserController
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function index()
    {
        $users = $this->userService->getAllUsers();
        echo json_encode($users);
    }

    public function show($id)
    {
        $user = $this->userService->getUserById($id);
        if ($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'User not found']);
        }
    }

    public function store()
    {
        $user = $this->userService->createUser($_POST);
        echo json_encode($user);
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $user = $this->userService->updateUser($id, $data);
        if ($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'User not found']);
        }
    }

    public function delete($id)
    {
        $deleted = $this->userService->deleteUser($id);
        if ($deleted) {
            echo json_encode(['message' => 'User deleted']);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'User not found']);
        }
    }
}
