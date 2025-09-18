<?php

require_once __DIR__ . '/Controllers/AuthController.php';
require_once __DIR__ . '/Controllers/UserController.php';


$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

switch ($url) {
    case '/':
    case '/login':
        $controller = new AuthController();
        if ($method === 'POST') {
            $controller->login();
        } else {
            $controller->showLoginForm();
        }
        break;

    case '/logout':
        $controller = new AuthController();
        $controller->logout();
        break;

    case '/users':
        $controller = new UserController();
        $controller->index();
        break;
    default:
        http_response_code(404);
        echo("Страница не найдена");
        break;
}