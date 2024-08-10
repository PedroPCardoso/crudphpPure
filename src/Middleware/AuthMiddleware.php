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
            $user = $this->userService->getUserByToken($token);

            if ($user) {
                return true;
            }
        }

        http_response_code(401);
        echo json_encode(["message" => "Unauthorized"]);
        return false;
    }
}
