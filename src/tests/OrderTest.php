<?php

use PHPUnit\Framework\TestCase;

class OrderApiTest extends TestCase
{
    private $baseUrl = 'http://localhost:8000';
    private $token;
    private $orderId;
    protected function setUp(): void
    {
        parent::setUp();
        $response = $this->makeRequest('POST', '/login', [
            'email' => 'admin@example.com',
            'password' => 'adminpassword'
        ]);
        $this->token = $response['token'];
        $response = $this->makeRequest('GET', '/orders', [], $this->token);
        $this->orderId = $response['data'][0]['id'];

    }

    public function testListOrders()
    {
        $response = $this->makeRequest('GET', '/orders', [], $this->token);
        $this->assertEquals(200, $response['status_code']);
        $this->assertIsArray($response['data']);
    }

    public function testCreateOrder()
    {
        $response = $this->makeRequest('POST', '/orders', [
            'user_id' => 1,
            'quantity' =>  rand(0, 100),
            'description' => 'Order description',
            'price' =>  rand(0, 100000) / 10
        ], $this->token);
        $this->assertEquals(201, $response['status_code']);
    }

    /**
     * @depends testCreateOrder
     */
    public function testShowOrder()
    {
        $this->assertNotNull($this->orderId, 'O orderId deve estar definido');
        $response = $this->makeRequest('GET', "/orders/{$this->orderId}", [], $this->token);
        $this->assertEquals(200, $response['status_code']);
        
        $this->assertArrayHasKey('description', $response['data']);
    }

    /**
     * @depends testCreateOrder
     */
    public function testUpdateOrder()
    {
        $this->assertNotNull($this->orderId, 'O orderId deve estar definido');     
        $response = $this->makeRequest('PUT', "/orders/{$this->orderId}", [
            'product_name' => 'Updated Order',
            'quantity' => 3,
            'price' => 249.99
        ], $this->token);

        $this->assertEquals(200, $response['status_code']);
    }

    /**
     * @depends testCreateOrder
     */
    public function testDeleteOrder()
    {
        $this->assertNotNull($this->orderId, 'O orderId deve estar definido');     
        $response = $this->makeRequest('DELETE', "/orders/{$this->orderId}", [], $this->token);
        $this->assertEquals(204, $response['status_code']);
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
}
