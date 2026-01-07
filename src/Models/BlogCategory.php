<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

class BlogCategory extends Model
{
    protected static string $table = 'blog_categories';

    public static function all(): array
    {
        try {
            return Database::fetchAll("SELECT * FROM blog_categories ORDER BY name");
        } catch (\Throwable $e) {
            return static::getMockData();
        }
    }

    public static function createCategory(array $data): int
    {
        return Database::insert('blog_categories', $data);
    }

    public static function deleteCategory(int $id): int
    {
        return Database::delete('blog_categories', 'id = :id', ['id' => $id]);
    }

    protected static function getMockData(): array
    {
        return [
            ['id' => 1, 'name' => 'Endüstriyel Verimlilik', 'slug' => 'endustriyel-verimlilik'],
            ['id' => 2, 'name' => 'Yenilenebilir Enerji', 'slug' => 'yenilenebilir-enerji'],
            ['id' => 3, 'name' => 'Haberler & Duyurular', 'slug' => 'haberler'],
            ['id' => 4, 'name' => 'Teknoloji Trendleri', 'slug' => 'teknoloji']
        ];
    }
}
