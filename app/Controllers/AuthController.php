<?php

require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Auth/Auth.php';

class AuthController {
    private $auth;
    private $userModel;

    public function __construct(){
        $this->auth = new Auth();
        $this->userModel = new User();
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
                $error = 'Не заполненно поле логин/пароль';
                require __DIR__ . '/../Views/auth/login.php';
                return;
            }

            if ($user = $this->auth->login($login, $password)) {
                if ($this->userModel->isAdmin($user['id'])) {
                    header('Location: /users');
                } else {
                    $this->auth->logout();
                    $error = 'Недостаточно прав для совершения данного действия';
                    require __DIR__ . '/../Views/auth/login.php';
                }
                exit;
            } else {
                $error = 'Неверный логин/пароль';
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