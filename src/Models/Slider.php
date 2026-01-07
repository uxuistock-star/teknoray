<?php

namespace App\Models;

use App\Core\Database;

class Slider
{
    public static function all(): array
    {
        return Database::fetchAll("SELECT * FROM slider ORDER BY display_order ASC, id ASC");
    }

    public static function allActive(): array
    {
        return Database::fetchAll("SELECT * FROM slider WHERE is_active = 1 ORDER BY display_order ASC, id ASC");
    }

    public static function find(int $id): ?array
    {
        return Database::fetch("SELECT * FROM slider WHERE id = :id", ['id' => $id]);
    }

    public static function create(array $data): int
    {
        return Database::insert('slider', $data);
    }

    public static function update(int $id, array $data): int
    {
        return Database::update('slider', $data, 'id = :id', ['id' => $id]);
    }

    public static function delete(int $id): int
    {
        return Database::delete('slider', 'id = :id', ['id' => $id]);
    }
}
