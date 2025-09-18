<?php

require_once __DIR__ . '/../../config/database.php';

class Auth {
    private $pdo;

    public function __construct(){
        require_once __DIR__ . '/../../config/database.php';
        $database = new \DB();
        $this->pdo = $database->getConnection();
    }

    public function login($login, $password) {
        require_once __DIR__ . '/../Models/User.php';

        $userModel = new User();
        $user = $userModel->findByLogin($login);

        if ($user && password_verify($password, $user['password']) && $user['role_id'] == 1) {
            $this->createSession($user['id']);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['login'] = $user['login'];
            $_SESSION['role_id'] = $user['role_id'];

            return $user;
        }

        return false;
    }

    public function logout() {
        session_start();
        session_destroy();
    }

    public function check(){
        session_start();
        return isset($_SESSION['user_id']);
    }

    private function createSession($userId){
        session_start();
        $_SESSION['expires'] = time() + 3600;
    }
}