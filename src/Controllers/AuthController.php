<?php

require_once 'Services/AuthService.php';

class AuthController
{
    private $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function login()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['email']) || !isset($data['password'])) {
            http_response_code(400);
            echo json_encode(["message" => "Email and password are required"]);
            return;
        }

        $user = $this->authService->validateCredentials($data['email'], $data['password']);

        if ($user) {
            $token = $this->generateToken($user['id']);
            $this->authService->updateUserToken($user['id'], $token); // Atualize o token no banco
            echo json_encode(["token" => $token]);
        } else {
            http_response_code(401);
            echo json_encode(["message" => "Invalid credentials"]);
        }
    }

    private function generateToken($userId)
    {
        return bin2hex(random_bytes(32)); // Gera um token seguro
    }
}

