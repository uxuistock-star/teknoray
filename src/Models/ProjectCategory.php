<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

class ProjectCategory extends Model
{
    protected static string $table = 'project_categories';

    public static function all(): array
    {
        try {
            return Database::fetchAll("SELECT * FROM project_categories ORDER BY name");
        } catch (\Throwable $e) {
            return static::getMockData();
        }
    }

    public static function createCategory(array $data): int
    {
        return Database::insert('project_categories', $data);
    }

    public static function deleteCategory(int $id): int
    {
        return Database::delete('project_categories', 'id = :id', ['id' => $id]);
    }

    protected static function getMockData(): array
    {
        return [
            ['id' => 1, 'name' => 'Endüstriyel Yapı', 'slug' => 'endustriyel-yapi'],
            ['id' => 2, 'name' => 'Enerji', 'slug' => 'enerji'],
            ['id' => 3, 'name' => 'Lojistik', 'slug' => 'lojistik'],
        ];
    }
}
