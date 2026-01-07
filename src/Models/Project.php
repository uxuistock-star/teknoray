<?php

namespace App\Models;

use App\Core\Database;

class Project
{
    public static function all(): array
    {
        return Database::fetchAll("SELECT * FROM projects ORDER BY created_at DESC");
    }

    public static function find(int $id): ?array
    {
        return Database::fetch("SELECT * FROM projects WHERE id = :id", ['id' => $id]);
    }

    public static function findBySlug(string $slug): ?array
    {
        return Database::fetch("SELECT * FROM projects WHERE slug = :slug", ['slug' => $slug]);
    }

    public static function getCategories(): array
    {
        try {
            $row = Database::fetch(
                "SELECT COUNT(*) AS c FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = 'project_categories'"
            );
            if (!empty($row) && (int) ($row['c'] ?? 0) > 0) {
                $cats = Database::fetchAll("SELECT name FROM project_categories ORDER BY name");
                return array_values(array_filter(array_map(fn($r) => $r['name'] ?? null, $cats)));
            }
        } catch (\Throwable $e) {
            // fallback below
        }

        $results = Database::fetchAll("SELECT DISTINCT category FROM projects ORDER BY category");
        return array_column($results, 'category');
    }

    public static function create(array $data): int
    {
        // Decode gallery if it's a string
        if (isset($data['gallery']) && is_string($data['gallery'])) {
            $data['gallery'] = $data['gallery'];
        } elseif (isset($data['gallery']) && is_array($data['gallery'])) {
            $data['gallery'] = json_encode($data['gallery']);
        }

        return Database::insert('projects', $data);
    }

    public static function update(int $id, array $data): int
    {
        // Decode gallery if it's a string
        if (isset($data['gallery']) && is_array($data['gallery'])) {
            $data['gallery'] = json_encode($data['gallery']);
        }

        return Database::update('projects', $data, 'id = :id', ['id' => $id]);
    }

    public static function delete(int $id): int
    {
        return Database::delete('projects', 'id = :id', ['id' => $id]);
    }

    public static function prepareForView(array $project): array
    {
        if (isset($project['gallery']) && is_string($project['gallery'])) {
            $project['gallery'] = json_decode($project['gallery'], true) ?: [];
        }
        return $project;
    }
}
