<?php

namespace App\Models;

use App\Core\Database;

class ReferenceLogo
{
    public static function all(): array
    {
        return Database::fetchAll("SELECT * FROM reference_logos ORDER BY display_order ASC, id ASC");
    }

    public static function create(array $data): int
    {
        return Database::insert('reference_logos', $data);
    }

    public static function delete(int $id): int
    {
        return Database::delete('reference_logos', 'id = :id', ['id' => $id]);
    }
}
