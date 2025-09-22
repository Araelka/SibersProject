<?php

require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Auth/Auth.php';

/**
 * Controller for handling authentication logic.
 */
class AuthController {
    private $auth;
    private $userModel;

    /**
     * Constructor to initialize authentication and user model.
     */
    public function __construct(){
        $this->auth = new Auth();
        $this->userModel = new User();
    }

    /**
     * Show the login form.
     */
    public function showLoginForm(){
        if ($this->auth->check()) {
            header('Location: /users');
            exit;
        }

        require __DIR__ . '/../Views/auth/login.php';
    }

    /**
     * Handle login form submission.
     */
    public function login (){
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $login = trim($_POST['login'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($login) || empty($password)){
                $error = 'The login/password field is not filled in';
                require __DIR__ . '/../Views/auth/login.php';
                return;
            }

            if ($user = $this->auth->login($login, $password)) {
                if ($this->userModel->isAdmin($user['id'])) {
                    header('Location: /users');
                } else {
                    $this->auth->logout();
                    $error = 'You do not have sufficient permissions to perform this action';
                    require __DIR__ . '/../Views/auth/login.php';
                }
                exit;
            } else {
                $error = 'Invalid login/password';
                require __DIR__ . '/../Views/auth/login.php';
                return;
            }
        }
    }

    /**
     * Handle user logout.
     */
    public function logout(){
        $this->auth->logout();
        header('Location: /login');
        exit;
    }
}