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

        if (!isset($_POST['email']) || !isset($_POST['password'])) {
            http_response_code(400);
            echo json_encode(["message" => "Email and password are required"]);
            return;
        }

        $user = $this->authService->validateCredentials($_POST['email'], $_POST['password']);

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

