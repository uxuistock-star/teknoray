<?php

namespace App\Models;

use App\Core\Database;

class BlogPost
{
    public static function all(): array
    {
        return Database::fetchAll("SELECT * FROM blog_posts ORDER BY created_at DESC");
    }

    public static function find(int $id): ?array
    {
        return Database::fetch("SELECT * FROM blog_posts WHERE id = :id", ['id' => $id]);
    }

    public static function findBySlug(string $slug): ?array
    {
        return Database::fetch("SELECT * FROM blog_posts WHERE slug = :slug", ['slug' => $slug]);
    }

    public static function create(array $data): int
    {
        return Database::insert('blog_posts', $data);
    }

    public static function update(int $id, array $data): int
    {
        return Database::update('blog_posts', $data, 'id = :id', ['id' => $id]);
    }

    public static function delete(int $id): int
    {
        return Database::delete('blog_posts', 'id = :id', ['id' => $id]);
    }

    public static function incrementViews(int $id): void
    {
        Database::query("UPDATE blog_posts SET views = views + 1 WHERE id = :id", ['id' => $id]);
    }
}
