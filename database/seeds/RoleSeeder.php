<?php

require_once __DIR__ . '/../../config/database.php';

class RoleSeeder {
    private $pdo;

    public function __construct() {
        $database = new DB();
        $this->pdo = $database->getConnection();
    }

    public function run() {
        echo "Start RoleSeeder...\n";

        $roles = [
            ['name' => 'admin', 'description' => 'Администратор'],
            ['name' => 'user', 'description' => 'Пользователь']
        ];

        $sql = $this->pdo->prepare("INSERT IGNORE INTO roles (name, description) VALUES (?, ?)");

        foreach ($roles as $role) {
            $sql->execute([$role['name'], $role['description']]);
        }

        echo "RoleSeeder completed!\n";
    }
}