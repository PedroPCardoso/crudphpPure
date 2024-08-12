<?php

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private $baseUrl = 'http://localhost:8000';
    private $token;

    protected function setUp(): void
    {
        parent::setUp();

        $response = $this->makeRequest('POST', '/login', ['email' => 'admin@example.com', 'password' => 'adminpassword']);
        $this->token = $response['token'];
    }

    public function testListUsers()
    {
        $response = $this->makeRequest('GET', '/users', [], $this->token);
        $this->assertEquals(200, $response['status_code']);
        $this->assertIsArray($response['data']);
    }

    public function testCreateUser()
    {
        $response = $this->makeRequest('POST', '/users', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'document' => '123456789',
            'email' => $this->generateRandomEmail(),
            'password' => 'password',
            'phone_number' => '1234567890',
            'birth_date' => '1990-01-01'
        ], $this->token);

        
        $this->assertEquals(201, $response['status_code']);
    }

    private function makeRequest($method, $endpoint, $data = [], $token = null)
    {
        $url = $this->baseUrl . $endpoint;
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->token
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);

        curl_close($ch);

        return json_decode($response, true);
    }

    private function generateRandomEmail()
    {
        function generateRandomString($length = 10)
        {
            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        // Nome aleatório
        $firstName = generateRandomString(rand(5, 10));
        $lastName = generateRandomString(rand(5, 10));

        // Domínio aleatório
        $domain = generateRandomString(rand(5, 10)) . '.com';

        // Gerar e-mail
        $email = strtolower($firstName . '.' . $lastName . '@' . $domain);

        return $email;
    }
}
