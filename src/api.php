<?php

require_once 'Controllers/UserController.php';
require_once 'Controllers/OrderController.php';
require_once 'Controllers/AuthController.php';
require_once 'Middleware/AuthMiddleware.php';

$authMiddleware = new AuthMiddleware();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri === '/login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new AuthController();
    $controller->login();
} elseif ($authMiddleware->validateToken()) {
    if ($uri === '/users' && $_SERVER['REQUEST_METHOD'] === 'GET') {
        $controller = new UserController();
        $controller->index();
    } elseif ($uri === '/users' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new UserController();
        $controller->store();
    } elseif (preg_match('/\/users\/\d+/', $uri) && $_SERVER['REQUEST_METHOD'] === 'GET') {
        $controller = new UserController();
        $controller->show(basename($uri));
    } elseif (preg_match('/\/users\/\d+/', $uri) && $_SERVER['REQUEST_METHOD'] === 'PUT') {
        $controller = new UserController();
        $controller->update(basename($uri));
    } elseif (preg_match('/\/users\/\d+/', $uri) && $_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $controller = new UserController();
        $controller->delete(basename($uri));
    } elseif ($uri === '/orders' && $_SERVER['REQUEST_METHOD'] === 'GET') {
        $controller = new OrderController();
        $controller->index();
    } elseif ($uri === '/orders' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new OrderController();
        $controller->store();
    } elseif (preg_match('/\/orders\/\d+/', $uri) && $_SERVER['REQUEST_METHOD'] === 'GET') {
        $controller = new OrderController();
        $controller->show(basename($uri));
    } elseif (preg_match('/\/orders\/\d+/', $uri) && $_SERVER['REQUEST_METHOD'] === 'PUT') {
        $controller = new OrderController();
        $controller->update(basename($uri));
    } elseif (preg_match('/\/orders\/\d+/', $uri) && $_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $controller = new OrderController();
        $controller->delete(basename($uri));
    } else {
        http_response_code(404);
        echo json_encode(["message" => "Not Found"]);
    }
} else {
    http_response_code(401);
    echo json_encode(["message" => "Unauthorized"]);
}
