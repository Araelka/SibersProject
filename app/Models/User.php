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

    public function isAdmin($id) {
        $sql = $this->pdo->prepare("SELECT role_id FROM users WHERE id = ? LIMIT 1");
        $sql->execute([$id]);
        $result = $sql->fetch(PDO::FETCH_ASSOC);

        return $result && $result['role_id'] == 1;
    }

    public function update ($id, $data) {
        try {
            $sql = $this->pdo->prepare("
                UPDATE users
                SET
                    login = ?,
                    role_id = ?,
                    firstName = ?,
                    secondName = ?,
                    gender = ?,
                    birthdate = ?,
                    updated_at = NOW()
                WHERE id = ?
            ");

            $sql->execute([
                $data['login'],
                $data['role_id'],
                $data['firstName'],
                $data['secondName'],
                $data['gender'],
                $data['birthdate'],
                $id
            ]);

            if (isset($data['password']) && !empty($data['password'])) {
                $sql = $this->pdo->prepare("
                    UPDATE users
                    SET
                        password = ?
                    WHERE id = ?
                ");

                $sql->execute([
                    password_hash($data['password'], PASSWORD_DEFAULT),
                    $id
                ]);
            }

            return true;
        } catch (Exception $e) {
            error_log("Ошибка при обновлении пользователя: " . $e->getMessage());
            return false;
        }
    }

    public function create($data) {
        try {
            $sql = $this->pdo->prepare("
                INSERT INTO users (login, password, role_id, firstName, secondName, gender, birthdate, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
            ");

            $result = $sql->execute([
                $data['login'],
                password_hash($data['password'], PASSWORD_DEFAULT),
                $data['role_id'],
                $data['firstName'],
                $data['secondName'],
                $data['gender'],
                $data['birthdate'],
            ]);

            if ($result) {
                return $this->pdo->lastInsertId();
            }

            return false;
        } catch (Exception $e) {
            error_log("Ошибка при создании пользователя: " . $e->getMessage());
            return false;
        }
    }

    public function delete ($id) {
        try {
            $sql = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
            return $sql->execute([$id]);
        } catch (Exception $e) {
            error_log("Ошибка при удалении пользователя: " . $e->getMessage());
            return false;
        }
    }

    public function existByLogin($login, $id) {
        $sql = $this->pdo->prepare("SELECT id FROM users WHERE login = ? AND id != ? LIMIT 1");
        $sql->execute([$login, $id]);
        return $sql->fetch() !== false;
    }

}