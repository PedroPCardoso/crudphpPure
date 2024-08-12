<?php

require_once __DIR__ . '/../Models/User.php';

class UserService
{
    /**
     * Retorna todos os usuários.
     *
     * @return array
     */
    public function getAllUsers(): array
    {
        return User::all()->toArray();
    }

    /**
     * Retorna um usuário pelo ID.
     *
     * @param int $id ID do usuário.
     * @return array|null
     */
    public function getUserById(int $id): ?array
    {
        $user = User::find($id);
        return $user ? $user->toArray() : null;
    }

    /**
     * Cria um novo usuário.
     *
     * @param array $data Dados para criar um novo usuário.
     * @return array
     */
    public function createUser(array $data): array
    {
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        return User::create($data)->toArray();
    }

    /**
     * Atualiza um usuário pelo ID.
     *
     * @param int $id ID do usuário.
     * @param array $data Dados atualizados do usuário.
     * @return array|null
     */
    public function updateUser(int $id, array $data): ?array
    {
        $user = User::find($id);
        if ($user) {
            $user->update($data);
            return $user->toArray();
        }
        return null;
    }

    /**
     * Deleta um usuário pelo ID.
     *
     * @param int $id ID do usuário.
     * @return bool
     */
    public function deleteUser(int $id): bool
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return true;
        }
        return false;
    }

    /**
     * Retorna um usuário pelo token de autenticação.
     *
     * @param string $token Token de autenticação do usuário.
     * @return array|null
     */
    public function getUserByToken(string $token): ?array
    {
        $user = User::where('auth_token', $token)->first();
        return $user ? $user->toArray() : null;
    }
}
