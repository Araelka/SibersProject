<?php
echo "The start of migrations...\n";

require_once __DIR__ . '/../config/database.php';

$migrations = [
    '000001_create_roles_table.php' => 'CreateRolesTable',
    '000002_create_users_table.php' => 'CreateUsersTable',
];


foreach ($migrations as $migration => $className) {
    $filePath = __DIR__ . '/migrations/' . $migration;

    if (file_exists($filePath)) {
        echo "Migration: $className\n";
        require_once $filePath;

        if (class_exists($className)) {
            $migrationInstance = new $className;
            $migrationInstance->up();
        }  
    } 
    

}
echo "All migrations are completed!\n";