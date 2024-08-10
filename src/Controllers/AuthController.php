<?php

require_once 'Services/UserService.php';

class AuthController
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function login()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['email']) || !isset($data['document'])) {
            http_response_code(400);
            echo json_encode(["message" => "Email and document are required"]);
            return;
        }

        $user = $this->userService->authenticateUser($data['email'], $data['document']);

        if ($user) {
            $token = $this->generateToken($user['id']);
            echo json_encode(["token" => $token]);
        } else {
            http_response_code(401);
            echo json_encode(["message" => "Invalid credentials"]);
        }
    }

    private function generateToken($userId)
    {
        // Gera um token simples. Em produção, use JWT ou outro método seguro
        return base64_encode($userId . ':' . bin2hex(random_bytes(16)));
    }
}
