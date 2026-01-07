<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Autoloader.php';

use App\Core\App;

// Manual Env (Fallback)
$_ENV['DB_HOST'] = 'localhost';
$_ENV['DB_NAME'] = 'teknoray_cms';
$_ENV['DB_USER'] = 'root';
$_ENV['DB_PASS'] = '';
$_ENV['APP_ENV'] = 'local';

// Init App
$app = new App();
$app->run();
