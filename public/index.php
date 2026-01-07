<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Autoloader.php';

use App\Core\App;

// Manual Env (Fallback)
if (!isset($_ENV['DB_HOST']) && getenv('DB_HOST') === false) {
    $_ENV['DB_HOST'] = 'localhost';
}
if (!isset($_ENV['DB_NAME']) && getenv('DB_NAME') === false) {
    $_ENV['DB_NAME'] = 'teknoray_cms';
}
if (!isset($_ENV['DB_USER']) && getenv('DB_USER') === false) {
    $_ENV['DB_USER'] = 'root';
}
if (!isset($_ENV['DB_PASS']) && getenv('DB_PASS') === false) {
    $_ENV['DB_PASS'] = '';
}
if (!isset($_ENV['APP_ENV']) && getenv('APP_ENV') === false) {
    $_ENV['APP_ENV'] = 'local';
}

// Init App
$app = new App();
$app->run();
