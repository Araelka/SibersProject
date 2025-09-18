<?php

class User {
    public $pdo;

    public function __construct(){
        require_once __DIR__ . '/../../config/database.php';
        $database = new \DB();
        $this->pdo = $database->getConnection();
    }

    public function findByLogin($login) {
        $sql = $this->pdo->prepare("SELECT * FROM users WHERE login = ? LIMIT 1");
        $sql->execute([$login]);
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $sql = $this->pdo->prepare(query: "SELECT * FROM users WHERE id = ? LIMIT 1");
        $sql->execute([$id]);
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    public function findAll() {
        $sql = $this->pdo->prepare("SELECT * FROM users ORDER BY id ASC");
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllUsersWithRoles() {
        $sql = $this->pdo->prepare("
            SELECT user.*,
            role.description as role_name
            FROM users user
            LEFT JOIN roles role ON user.role_id = role.id
            ORDER BY user.id ASC
        ");

        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getALlRoles() {
        $sql = $this->pdo->prepare("SELECT * FROM roles ORDER BY id");
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

}