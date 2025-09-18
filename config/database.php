<?php

class DBConfig {
    const DB_HOST = '127.0.0.1';
    const DB_PORT = '3306';
    const DB_NAME = 'sibers';
    const DB_USER = 'root';
    const DB_PASSWORD = '123456';
    const DB_CHARSET = 'utf8mb4';
}

class DB {
    private static $conn;

    public static function getConnection(){
        if (self::$conn === null) {
            try {
                $conf = 'mysql:host=' . DBConfig::DB_HOST .
                ';dbname=' . DBConfig::DB_NAME . 
                ";charset=" . DBConfig::DB_CHARSET;

                self::$conn = new PDO($conf, DBConfig::DB_USER, DBConfig::DB_PASSWORD, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } catch (PDOException $e){
                die("Connection error: " . $e->getMessage());
            }
        }

        return self::$conn;
    }
}

class Migration {

    protected $pdo;

    public function __construct(){
        $this->pdo = $this->getConnection();
    }
    private function getConnection() {
        try {
            $pdo = new PDO(
                'mysql:host' . DBConfig::DB_HOST . ";charset=" . DBConfig::DB_CHARSET,
                DBConfig::DB_USER,
                DBConfig::DB_PASSWORD
            );


            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `" . DBConfig::DB_NAME . "`");
            $pdo->exec("USE `" . DBConfig::DB_NAME . "`");

            return $pdo;
        } catch (PDOException $e) {
            exit('Connection error: ' . $e->getMessage());
        }
    }
    public function createTable($tableName, $columns, $options = '') {
        $columnsSql = implode(', ', $columns);
        $sql = "CREATE TABLE IF NOT EXISTS `$tableName` ($columnsSql) $options";
        $this->pdo->exec($sql);
        echo "The '$tableName' table was created successfully\n";
    }

    public function dropTable($tableName){
        $sql = "DROP TABLE IF EXISTS `$tableName`";
        $this->pdo->exec($sql);
        echo "The  '$tableName' table has been deleted\n";
    }
}