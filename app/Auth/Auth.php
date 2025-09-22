<?php

require_once __DIR__ . '/../../config/database.php';

/**
 * Authentication logic for user login.
 */
class Auth {
    private $pdo;

    /**
     * Constructor to initialize the database connection.
     */
    public function __construct(){
        require_once __DIR__ . '/../../config/database.php';
        $database = new \DB();
        $this->pdo = $database->getConnection();
    }

    /**
     * Attempt to log in a user.
     * @param string $login User login.
     * @param string $password User password.
     * @return array|false User data on success, false on failure.
     */
    public function login($login, $password) {
        require_once __DIR__ . '/../Models/User.php';

        $userModel = new User();
        $user = $userModel->findByLogin($login);

        if ($user && password_verify($password, $user['password'])) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['login'] = $user['login'];
            $_SESSION['role_id'] = $user['role_id'];

            return $user;
        }

        return false;
    }

    /**
     * Log out the current user.
     */
    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
    }

    /**
     * Get the current user data.
     * @return array|null User data or null if not logged in.
     */
    public function user() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            return null;
        }

        $userId = $_SESSION['user_id'];

        require_once __DIR__ . '/../Models/User.php';

        $userModel = new User();

        return $userModel->findById($userId);
    }

    /**
     * Check if a user is logged in.
     * @return bool True if logged in, false otherwise.
     */
    public function check(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user_id']);
    }

}