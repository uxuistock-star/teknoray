<?php

namespace App\Core;

class Helper
{
    public static function generateSlug(string $text): string
    {
        // Turkish character replacement
        $turkish = ['ş', 'Ş', 'ı', 'İ', 'ğ', 'Ğ', 'ü', 'Ü', 'ö', 'Ö', 'ç', 'Ç'];
        $english = ['s', 's', 'i', 'i', 'g', 'g', 'u', 'u', 'o', 'o', 'c', 'c'];
        $text = str_replace($turkish, $english, $text);

        // Convert to lowercase
        $text = mb_strtolower($text, 'UTF-8');

        // Replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // Trim
        $text = trim($text, '-');

        // Remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // Remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        return $text ?: 'n-a';
    }

    public static function sanitize(string $text): string
    {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }

    public static function redirect(string $url): never
    {
        header("Location: $url");
        exit;
    }

    public static function old(string $key, $default = '')
    {
        return $_POST[$key] ?? $default;
    }
}
