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

        $currentUser  = $this->auth->user();

        if (!$this->userModel->isAdmin($currentUser['id'])){
            $error = 'Недостаточно прав для совершения данного действия';
            header('Location: /login');
            exit;
        }

        $users = $this->userModel->getAllUsersWithRoles();

        require __DIR__ . '/../Views/users/index.php';   
    }

    public function showEditForm($id) {
        if (!$this->auth->check()) {
            header('Location: /login');
            exit;
        }

        $currentUser  = $this->auth->user();

        if (!$this->userModel->isAdmin($currentUser['id'])){
            $error = 'Недостаточно прав для совершения данного действия';
            header('Location: /login');
            exit;
        }

        $user = $this->userModel->findById($id);

        if (!$user) {
            header('Location: /users');
            exit;
        }

        $roles = $this->userModel->getALlRoles();

        require __DIR__ . '/../Views/users/user.php';
    }

    public function edit($id) {
        if (!$this->auth->check()) {
            header('Location: /login');
            exit;
        }

        $currentUser  = $this->auth->user();

        if (!$this->userModel->isAdmin($currentUser['id'])){
            $error = 'Недостаточно прав для совершения данного действия';
            header('Location: /login');
            exit;
        }

        $user = $this->userModel->findById($id);

        if (!$user) {
            header('Location: /users');
            exit;
        }

        $login = trim($_POST['login']);
        $password = $_POST['password'];
        $role_id = $_POST['role'];
        $firstName = trim($_POST['firstName']);
        $secondName = trim($_POST['secondName']);
        $gender = $_POST['gender'];
        $birthdate = $_POST['birthdate'];

        $errors = [];

        if (empty($login)) {
            $errors[] = 'Поле "Логин" не заполненно';
        }

        if ($this->userModel->existByLogin($login, $id)) {
            $errors[] = 'Пользователь с таким логином уже существует';
        }

        if (empty($role_id)) {
            $errors[] = 'Поле "Роль" не заполненно';
        }

        if (empty($firstName)) {
            $errors[] = 'Поле "Имя" не заполненно';
        }

        if (empty($secondName)) {
            $errors[] = 'Поле "Фамилия" не заполненно';
        }

        if (empty($gender)) {
            $errors[] = 'Поле "Пол" не заполненно';
        }

        if (empty($birthdate)) {
            $errors[] = 'Поле "Дата рождения" не заполненно';
        }

        if (!empty($errors)) {
            $error = implode('<br>', $errors);
            $roles = $this->userModel->getALlRoles();
            require __DIR__ . '/../Views/users/user.php';
            return;
        }

        $userData = [
            'login' => $login,
            'role_id' => $role_id,
            'firstName' => $firstName,
            'secondName' => $secondName,
            'gender' => $gender,
            'birthdate' => $birthdate,
        ];

        if (!empty($password)) {
            $userData['password'] = $password;
        }

        if ($this->userModel->update($id, $userData)) {
            header('Location: /users');
            exit;
        } else {
            $error = 'Ошибка при обновлении пользователя';
            $roles = $this->userModel->getALlRoles();
            require __DIR__ . '/../Views/users/user.php';
            return;
        }
    }

    public function destroy() {
        if (!$this->auth->check()) {
            header('Location: /login');
            exit;
        }

        $currentUser  = $this->auth->user();

        if (!$this->userModel->isAdmin($currentUser['id'])){
            $error = 'Недостаточно прав для совершения данного действия';
            header('Location: /login');
            exit;
        }

        $userId = $_POST['user_id'];

        $user = $this->userModel->findById($userId);

        if (!$user) {
            header('Location: /users');
            exit;
        }


        if ($this->userModel->isAdmin($userId) || $user['id'] == $currentUser['id']){
            $error = 'Недостаточно прав для совершения данного действия';
            header('Location: /users');
            return;
        }

        if ($this->userModel->delete($userId)) {
            header('Location: /users');
            exit;
        } else {
            $error = 'Ошибка при удалении пользователя';
            require __DIR__ . '/../Views/users/index.php';
            return;
        }


    }
}