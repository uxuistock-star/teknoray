<?php

namespace App\Core;

use PDO;

abstract class Model
{
    protected static string $table;
    protected static string $primaryKey = 'id';

    /**
     * Get all records
     */
    public static function all(): array
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->query("SELECT * FROM " . static::$table);
            return $stmt->fetchAll();
        } catch (\Exception $e) {
            // Log error or return mock data if in dev/demo mode
            return static::getMockData();
        }
    }

    /**
     * Find record by ID
     */
    public static function find($id)
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT * FROM " . static::$table . " WHERE " . static::$primaryKey . " = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Create new record
     */
    public static function create(array $data): bool
    {
        try {
            $db = Database::getInstance()->getConnection();
            $columns = implode(', ', array_keys($data));
            $values = ':' . implode(', :', array_keys($data));

            $sql = "INSERT INTO " . static::$table . " ($columns) VALUES ($values)";
            $stmt = $db->prepare($sql);

            return $stmt->execute($data);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Mock data hook for development/demo purposes when DB is offline
     */
    protected static function getMockData(): array
    {
        return [];
    }
}
