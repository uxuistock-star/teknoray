<?php

namespace App\Models;

use App\Core\Database;

class Setting
{
    public static function get(string $key, $default = null)
    {
        $result = Database::fetch(
            "SELECT setting_value FROM settings WHERE setting_key = :key",
            ['key' => $key]
        );

        return $result ? $result['setting_value'] : $default;
    }

    public static function set(string $key, $value, string $group = 'general'): void
    {
        $existing = Database::fetch(
            "SELECT id FROM settings WHERE setting_key = :key",
            ['key' => $key]
        );

        if ($existing) {
            Database::update(
                'settings',
                ['setting_value' => $value],
                'setting_key = :key',
                ['key' => $key]
            );
        } else {
            Database::insert('settings', [
                'setting_key' => $key,
                'setting_value' => $value,
                'setting_group' => $group
            ]);
        }
    }

    public static function getByGroup(string $group): array
    {
        $results = Database::fetchAll(
            "SELECT setting_key, setting_value FROM settings WHERE setting_group = :group",
            ['group' => $group]
        );

        $settings = [];
        foreach ($results as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }

        return $settings;
    }

    public static function getAllGrouped(): array
    {
        $results = Database::fetchAll("SELECT setting_group, setting_key, setting_value FROM settings");

        $grouped = [];
        foreach ($results as $row) {
            $grouped[$row['setting_group']][$row['setting_key']] = $row['setting_value'];
        }

        return $grouped;
    }

    public static function bulkSet(array $settings, string $group): void
    {
        foreach ($settings as $key => $value) {
            self::set($key, $value, $group);
        }
    }
}
