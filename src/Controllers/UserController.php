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
        echo json_encode(['status_code' => 200, 'data' => $users]);
    }

    public function show($id)
    {
        $user = $this->userService->getUserById($id);
        if ($user) {
            echo json_encode(['status_code' => 200, 'data' => $user]);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'User not found']);
        }
    }

    public function store()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $user = $this->userService->createUser($data);
        echo json_encode(['status_code'=> 201, 'data' => $user]);
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $user = $this->userService->updateUser($id, $data);
        if ($user) {
            echo json_encode(['status_code' => 200, 'data' => $user]);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'User not found']);
        }
    }

    public function delete($id)
    {
        $deleted = $this->userService->deleteUser($id);
        if ($deleted) {
            echo json_encode(['status_code' => 204, 'message' => 'User deleted']);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'User not found']);
        }
    }
}
