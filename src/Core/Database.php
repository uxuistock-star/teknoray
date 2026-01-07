<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?Database $instance = null;
    private PDO $pdo;

    private function __construct()
    {
        $config = require __DIR__ . '/../../config/config.php';
        $dbConfig = $config['database'];

        $dsn = sprintf(
            "mysql:host=%s;dbname=%s;charset=%s",
            $dbConfig['host'],
            $dbConfig['database'],
            $dbConfig['charset']
        );

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password'], $options);
            $this->pdo->exec("SET NAMES utf8mb4 COLLATE utf8mb4_turkish_ci");
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            $isLocal = (($_ENV['APP_ENV'] ?? '') === 'local');
            if ($isLocal) {
                die("Database connection failed: " . $e->getMessage());
            }
            die('Database connection failed');
        }
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    // Static helper methods
    public static function query(string $sql, array $params = []): \PDOStatement
    {
        try {
            $stmt = self::getInstance()->getConnection()->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            error_log("Database Query Error: " . $e->getMessage() . " | SQL: " . $sql);
            $isLocal = (($_ENV['APP_ENV'] ?? '') === 'local');
            if ($isLocal) {
                throw new \RuntimeException("Database query failed: " . $e->getMessage());
            }
            throw new \RuntimeException('Database query failed');
        }
    }

    public static function fetch(string $sql, array $params = []): ?array
    {
        $result = self::query($sql, $params)->fetch();
        return $result ?: null;
    }

    public static function fetchAll(string $sql, array $params = []): array
    {
        return self::query($sql, $params)->fetchAll();
    }

    public static function insert(string $table, array $data): int
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        self::query($sql, $data);

        return (int) self::getInstance()->getConnection()->lastInsertId();
    }

    public static function update(string $table, array $data, string $where, array $whereParams = []): int
    {
        $setParts = [];
        foreach (array_keys($data) as $key) {
            $setParts[] = "{$key} = :{$key}";
        }
        $setClause = implode(', ', $setParts);

        $sql = "UPDATE {$table} SET {$setClause} WHERE {$where}";
        $stmt = self::query($sql, array_merge($data, $whereParams));

        return $stmt->rowCount();
    }

    public static function delete(string $table, string $where, array $whereParams = []): int
    {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        $stmt = self::query($sql, $whereParams);

        return $stmt->rowCount();
    }
}
