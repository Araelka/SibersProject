<?php

require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Auth/Auth.php';

class AuthController {
    private $auth;

    public function __construct(){
        $this->auth = new Auth();
    }

    public function showLoginForm(){
        if ($this->auth->check()) {
            header('Location: /users');
            exit;
        }

        require __DIR__ . '/../Views/auth/login.php';
    }

    public function login (){
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $login = trim($_POST['login'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($login) || empty($password)){
                $error = 'Заполните все поля';
                require __DIR__ . '/../Views/auth/login.php';
                return;
            }

            if ($user = $this->auth->login($login, $password)) {
                header('Location: /users');
                exit;
            } else {
                $error = 'Неверный логин/пароль или недостаточно прав';
                require __DIR__ . '/../Views/auth/login.php';
                return;
            }
        }
    }

    public function logout(){
        $this->auth->logout();
        header('Location: /login');
        exit;
    }
}