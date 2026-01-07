<?php

require_once __DIR__ . '/../src/Autoloader.php';

use App\Core\Database;

// Mock Env for script usage
$_ENV['DB_HOST'] = 'localhost';
$_ENV['DB_NAME'] = 'teknoray_db';
$_ENV['DB_USER'] = 'root';
$_ENV['DB_PASS'] = '';

echo "Connecting to Database...\n";

try {
    // Connect without DB name first to create it
    $dsn = "mysql:host={$_ENV['DB_HOST']};charset=utf8mb4";
    $pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$_ENV['DB_NAME']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Database created/verified.\n";

} catch (PDOException $e) {
    die("DB Connection Failed: " . $e->getMessage());
}

// Now use the App Wrapper
$db = Database::getInstance()->getConnection();

$queries = [
    "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        role ENUM('admin', 'editor') DEFAULT 'admin',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    "CREATE TABLE IF NOT EXISTS settings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        setting_key VARCHAR(50) UNIQUE NOT NULL,
        setting_value TEXT,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )",
    "CREATE TABLE IF NOT EXISTS projects (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(150) NOT NULL,
        slug VARCHAR(150) UNIQUE NOT NULL,
        description TEXT,
        client_name VARCHAR(100),
        completion_date DATE,
        thumbnail VARCHAR(255),
        images JSON,
        status ENUM('active', 'completed') DEFAULT 'completed',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    "CREATE TABLE IF NOT EXISTS services (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(150) NOT NULL,
        slug VARCHAR(150) UNIQUE NOT NULL,
        summary VARCHAR(255),
        content TEXT,
        icon VARCHAR(50),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    "CREATE TABLE IF NOT EXISTS blog_categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        slug VARCHAR(100) UNIQUE NOT NULL
    )",
    "CREATE TABLE IF NOT EXISTS blog_posts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        category_id INT,
        title VARCHAR(150) NOT NULL,
        slug VARCHAR(150) UNIQUE NOT NULL,
        content LONGTEXT,
        thumbnail VARCHAR(255),
        status ENUM('draft', 'published') DEFAULT 'draft',
        views INT DEFAULT 0,
        published_at TIMESTAMP NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (category_id) REFERENCES blog_categories(id) ON DELETE SET NULL
    )"
];

echo "Running Migrations...\n";

foreach ($queries as $sql) {
    try {
        $db->exec($sql);
        echo "Executed Table Creation.\n";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

echo "Database Setup Complete.\n";
