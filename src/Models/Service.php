<?php

namespace App\Models;

use App\Core\Database;

class Service
{
    public static function all(): array
    {
        return Database::fetchAll("SELECT * FROM services ORDER BY display_order ASC, id ASC");
    }

    public static function find(int $id): ?array
    {
        return Database::fetch("SELECT * FROM services WHERE id = :id", ['id' => $id]);
    }

    public static function create(array $data): int
    {
        return Database::insert('services', $data);
    }

    public static function update(int $id, array $data): int
    {
        return Database::update('services', $data, 'id = :id', ['id' => $id]);
    }

    public static function delete(int $id): int
    {
        return Database::delete('services', 'id = :id', ['id' => $id]);
    }
}
