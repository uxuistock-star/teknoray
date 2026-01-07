<?php

namespace App\Security;

class SecurityManager
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * CSRF Protection
     */
    public function generateCsrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public function validateCsrfToken(?string $token): bool
    {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], (string) $token);
    }

    /**
     * Honeypot Field
     */
    public function getHoneypotField(): string
    {
        // Hidden via CSS separately
        return '<div style="display:none;"><label>Leave this field empty</label><input type="text" name="hp_check" value=""></div>';
    }

    public function validateHoneypot(): bool
    {
        return empty($_POST['hp_check']);
    }

    /**
     * Rate Limiting (Basic Session/IP implementation)
     */
    public function checkRateLimit(string $key = 'global', int $limit = 5, int $seconds = 60): bool
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $sessionKey = "rate_limit_{$key}_{$ip}";

        $current = $_SESSION[$sessionKey] ?? ['count' => 0, 'time' => time()];

        if (time() - $current['time'] > $seconds) {
            // Reset
            $current = ['count' => 1, 'time' => time()];
        } else {
            $current['count']++;
        }

        $_SESSION[$sessionKey] = $current;

        return $current['count'] <= $limit;
    }

    /**
     * Input Sanitization using htmlspecialchars (basic) or HTMLPurifier if needed
     */
    public function sanitize(string $input): string
    {
        return htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}
