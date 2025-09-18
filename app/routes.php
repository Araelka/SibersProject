<?php

require_once __DIR__ . '/Controllers/AuthController.php';
require_once __DIR__ . '/Controllers/UserController.php';


$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

if ($url === '/' || $url === '/login') {
    $controller = new AuthController();
    if ($method === 'POST') {
        $controller->login();
    } else {
        $controller->showLoginForm();
    }
}

elseif ($url === '/logout') {
    $controller = new AuthController();
    $controller->logout();
}

elseif ($url === '/users') {
    $controller = new UserController();
    $controller->index();
}

elseif (preg_match('/^\/users\/edit\/(\d+)$/', $url, $matches)) {
    $userId = $matches[1];
    $controller = new UserController();
    $controller->edit($userId);
}

else {
    http_response_code(404);
    echo "Page not found";
}