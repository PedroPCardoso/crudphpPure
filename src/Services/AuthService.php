<?php

require_once 'Models/User.php';

class AuthService
{
    public function validateCredentials($email, $password)
    {
        $user = User::where('email', $email)->first();

        if ($user && password_verify($password, $user->password)) {
            return $user;
        }

        return null;
    }

    public function updateUserToken($userId, $token)
    {
        $user = User::find($userId);
        $user->auth_token = $token;
        $user->save();
    }
}
