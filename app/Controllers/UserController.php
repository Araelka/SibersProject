<?php

require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Auth/Auth.php';

class UserController {
    private $auth;
    private $userModel;

    public function __construct(){
        $this->auth = new Auth();
        $this->userModel = new User();
    }

    public function index(){
        if (!$this->auth->check()) {
            header('Location: /login');
            exit;
        }

        $users = $this->userModel->getAllUsersWithRoles();

        require __DIR__ . '/../Views/users/index.php';
        
    }
}