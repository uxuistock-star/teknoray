<?php

return [
    'database' => [
        'host' => $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?? 'localhost',
        'database' => $_ENV['DB_NAME'] ?? getenv('DB_NAME') ?? 'teknoray_cms',
        'username' => $_ENV['DB_USER'] ?? getenv('DB_USER') ?? 'root',
        'password' => $_ENV['DB_PASS'] ?? getenv('DB_PASS') ?? '',
        'charset' => 'utf8mb4',
    ],

    'app' => [
        'url' => $_ENV['APP_URL'] ?? getenv('APP_URL') ?? 'http://localhost',
        'name' => 'TeknoRay CMS',
    ],
];
