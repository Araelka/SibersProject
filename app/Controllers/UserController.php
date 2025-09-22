<?php

require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Auth/Auth.php';

/**
 * Controller for managing users.
 */
class UserController {
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
     * Display the list of users with pagination and sorting.
     */
    public function index(){
        if (!$this->auth->check()) {
            header('Location: /login');
            exit;
        }

        $currentUser  = $this->auth->user();

        if (!$this->userModel->isAdmin($currentUser['id'])){
            $error = 'You do not have sufficient permissions to perform this action';
            header('Location: /login');
            exit;
        }

        $sortField = $_GET['sort'] ?? 'id';
        $sortOrder = $_GET['order'] ?? 'ASC';
        $page = max(1, intval($_GET['page'] ?? 1));

        $sortFields = ['id', 'login', 'role_id', 'created_at', 'updated_at'];

        if (!in_array($sortField, $sortFields)){
            $sortField = 'id';
        }

        if (!in_array(strtoupper($sortOrder), ['ASC', 'DESC'])) {
            $sortOrder = 'ASC';
        }

        $totalUsers = $this->userModel->getTotalUsersCount();
        $totalPages = ceil($totalUsers / 10);
        $offset = ($page - 1) * 10;

        $users = $this->userModel->getAllUsersWithRoles($sortField, $sortOrder, 10, $offset);

        require __DIR__ . '/../Views/users/index.php';   
    }

    /**
     * Show the form for creating a new user.
     */
    public function showCreateForm() {
        if (!$this->auth->check()) {
            header('Location: /login');
            exit;
        }

        $currentUser  = $this->auth->user();

        if (!$this->userModel->isAdmin($currentUser['id'])){
            $error = 'You do not have sufficient permissions to perform this action';
            header('Location: /login');
            exit;
        }

        $roles = $this->userModel->getAllRoles();

        require __DIR__ . '/../Views/users/user.php';
    }

    /**
     * Handle user creation form submission.
     */
    public function create() {
        if (!$this->auth->check()) {
            header('Location: /login');
            exit;
        }

        $currentUser  = $this->auth->user();

        if (!$this->userModel->isAdmin($currentUser['id'])){
            $error = 'You do not have sufficient permissions to perform this action';
            header('Location: /login');
            exit;
        }

        $login = htmlspecialchars(trim($_POST['login']));
        $password = $_POST['password'];
        $role_id = $_POST['role'];
        $firstName = htmlspecialchars(trim($_POST['firstName']));
        $secondName = htmlspecialchars(trim($_POST['secondName']));
        $gender = $_POST['gender'];
        $birthdate = $_POST['birthdate'];

        $errors = [];

        if (empty($login) || strlen($login) > 100) {
            $errors[] = 'Invalid "login"';
        }

        if ($this->userModel->findByLogin($login)) {
            $errors[] = 'The username already exists';
        }

         if (empty($password) || strlen($password) < 6) {
            $errors[] = 'Invalid "password"';
        }

        if (empty($role_id)) {
            $errors[] = 'Invalid "role"';
        }

        if (empty($firstName) || strlen($firstName) > 50) {
            $errors[] = 'Invalid "firstName"';
        }

        if (empty($secondName) || strlen($secondName) > 50) {
            $errors[] = 'Invalid "secondName"';
        }

        if (empty($gender) || !in_array($gender, ['male', 'female'])) {
            $errors[] = 'Invalid "gender"';
        }

        if (empty($birthdate)) {
            $errors[] = 'Invalid "birthdate"';
        }

        if (!empty($errors)) {
            $error = implode('<br>', $errors);
            $roles = $this->userModel->getAllRoles();
            require __DIR__ . '/../Views/users/user.php';
            return;
        }

        $userData = [
            'login' => $login,
            'password' => $password,
            'role_id' => $role_id,
            'firstName' => $firstName,
            'secondName' => $secondName,
            'gender' => $gender,
            'birthdate' => $birthdate,
        ];

        if ($this->userModel->create( $userData)) {
            header('Location: /users');
            exit;
        } else {
            $error = 'User creation error';
            $roles = $this->userModel->getAllRoles();
            require __DIR__ . '/../Views/users/user.php';
            return;
        }
    }

    /**
     * Show the form for editing an existing user.
     * @param int $id User ID.
     */
    public function showEditForm($id) {
        if (!$this->auth->check()) {
            header('Location: /login');
            exit;
        }

        $currentUser  = $this->auth->user();

        if (!$this->userModel->isAdmin($currentUser['id'])){
            $error = 'You do not have sufficient permissions to perform this action';
            header('Location: /login');
            exit;
        }

        $user = $this->userModel->findById($id);

        if (!$user) {
            header('Location: /users');
            exit;
        }

        $roles = $this->userModel->getAllRoles();

        require __DIR__ . '/../Views/users/user.php';
    }

    /**
     * Handle user update form submission.
     * @param int $id User ID.
     */
    public function edit($id) {
        if (!$this->auth->check()) {
            header('Location: /login');
            exit;
        }

        $currentUser  = $this->auth->user();

        if (!$this->userModel->isAdmin($currentUser['id'])){
            $error = 'You do not have sufficient permissions to perform this action';
            header('Location: /login');
            exit;
        }

        $user = $this->userModel->findById($id);

        if (!$user) {
            header('Location: /users');
            exit;
        }

        $login = htmlspecialchars(trim($_POST['login']));
        $password = $_POST['password'];
        $role_id = $_POST['role'];
        $firstName = htmlspecialchars(trim($_POST['firstName']));
        $secondName = htmlspecialchars(trim($_POST['secondName']));
        $gender = $_POST['gender'];
        $birthdate = $_POST['birthdate'];

        $errors = [];

        if (empty($login) || strlen($login) > 100) {
            $errors[] = 'Invalid "login"';
        }

        if ($this->userModel->existByLogin($login, $id)) {
            $errors[] = 'The username already exists';
        }

        if (empty($role_id)) {
            $errors[] = 'Invalid "role"';
        }

        if (empty($firstName) || strlen($firstName) > 50) {
            $errors[] = 'Invalid "firstName"';
        }

        if (empty($secondName) || strlen($secondName) > 50) {
            $errors[] = 'Invalid "secondName"';
        }

        if (empty($gender) || !in_array($gender, ['male', 'female'])) {
            $errors[] = 'Invalid "gender"';
        }

        if (empty($birthdate)) {
            $errors[] = 'Invalid "birthdate"';
        }

        if (!empty($errors)) {
            $error = implode('<br>', $errors);
            $roles = $this->userModel->getAllRoles();
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

        if (!empty($password) && strlen($password) >= 6) {
            $userData['password'] = $password;
        }

        if ($this->userModel->update($id, $userData)) {
            header('Location: /users');
            exit;
        } else {
            $error = 'User update error';
            $roles = $this->userModel->getAllRoles();
            require __DIR__ . '/../Views/users/user.php';
            return;
        }
    }

    /**
     * Handle user deletion.
     */
    public function destroy() {
        if (!$this->auth->check()) {
            header('Location: /login');
            exit;
        }

        $currentUser  = $this->auth->user();

        if (!$this->userModel->isAdmin($currentUser['id'])){
            $error = 'You do not have sufficient permissions to perform this action';
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
            $error = 'You do not have sufficient permissions to perform this action';
            header('Location: /users');
            return;
        }

        if ($this->userModel->delete($userId)) {
            header('Location: /users');
            exit;
        } else {
            $error = 'User deletion error';
            require __DIR__ . '/../Views/users/index.php';
            return;
        }


    }
}