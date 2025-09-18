<?php

echo "Start seed...\n";

require_once __DIR__ . '/../../config/database.php';

require_once __DIR__ . '/RoleSeeder.php';
require_once __DIR__ . '/UserSeeder.php';

try {
    $roleSeeder = new RoleSeeder();
    $roleSeeder->run();

    $userSeeder = new UserSeeder();
    $userSeeder->run();

    echo "All seeders completed!";
} catch (Exception $e) {
    echo "Error seeders:" . $e->getMessage() . '\n';
    exit(1);
}