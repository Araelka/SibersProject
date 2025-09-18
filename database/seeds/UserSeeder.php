<?php

require_once __DIR__ . '/../../config/database.php';

class UserSeeder {
    private $pdo;

    public function __construct() {
        $database = new DB();
        $this->pdo = $database->getConnection();
    }

    public function run() {
        echo "Start UserSeeder...\n";

        $users = [
            ['login' => 'admin', 
            'password' => password_hash('admin', PASSWORD_DEFAULT),
            'role_id' => 1],
        ];

        $sql = $this->pdo->prepare("INSERT IGNORE INTO users (login, password, role_id) VALUES (?, ?, ?)");

        foreach ($users as $user) {
            $sql->execute([$user['login'], $user['password'], $user['role_id']]);
        }

        echo "UserSeeder completed!\n";
    }
}