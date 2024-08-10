<?php

require_once 'Services/UserService.php';

class AuthMiddleware
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function validateToken()
    {
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            $userId = $this->parseToken($token);

            if ($userId && $this->userService->getUserById($userId)) {
                return true;
            }
        }

        http_response_code(401);
        echo json_encode(["message" => "Unauthorized"]);
        return false;
    }

    private function parseToken($token)
    {
        // Simples decodificação do token (use um método mais seguro em produção)
        $parts = explode(':', base64_decode($token));
        return $parts[0] ?? null;
    }
}
