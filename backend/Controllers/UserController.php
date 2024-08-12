<?php

require_once __DIR__ . '/../Services/UserService.php';

class UserController
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    /**
     * Retorna todos os usuários.
     *
     * @return void
     */
    public function index(): void
    {
        $users = $this->userService->getAllUsers();        
        echo json_encode(['status_code' => 200, 'data' => $users]);
    }

    /**
     * Retorna um usuário pelo ID.
     *
     * @param int $id O ID do usuário.
     * @return void
     */
    public function show(int $id): void
    {
        $user = $this->userService->getUserById($id);
        if ($user) {
            echo json_encode(['status_code' => 200, 'data' => $user]);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'User not found']);
        }
    }

    /**
     * Cria um novo usuário.
     *
     * @return void
     */
    public function store(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $user = $this->userService->createUser($data);
        echo json_encode(['status_code' => 201, 'data' => $user]);
    }

    /**
     * Atualiza um usuário existente.
     *
     * @param int $id O ID do usuário.
     * @return void
     */
    public function update(int $id): void
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

    /**
     * Remove um usuário pelo ID.
     *
     * @param int $id O ID do usuário.
     * @return void
     */
    public function delete(int $id): void
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
