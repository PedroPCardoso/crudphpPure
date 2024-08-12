<?php

require_once 'Models/User.php';

class AuthService
{
    /**
     * Valida as credenciais do usuário.
     *
     * @param string $email O email do usuário.
     * @param string $password A senha do usuário.
     * @return User|null Retorna o objeto User se as credenciais forem válidas, caso contrário, retorna null.
     */
    public function validateCredentials(string $email, string $password): ?User
    {
        $user = User::where('email', $email)->first();

        if ($user && password_verify($password, $user->password)) {
            return $user;
        }

        return null;
    }

    /**
     * Atualiza o token de autenticação do usuário.
     *
     * @param int $userId O ID do usuário.
     * @param string $token O novo token de autenticação.
     * @return void
     */
    public function updateUserToken(int $userId, string $token): void
    {
        $user = User::find($userId);
        $user->auth_token = $token;
        $user->save();
    }
}

