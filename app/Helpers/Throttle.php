<?php
namespace App\Helpers;

class Throttle
{
    private const KEY = '_throttle';

    public static function tooManyAttempts(string $key, int $maxAttempts, int $decaySeconds): bool
    {
        self::cleanup($key, $decaySeconds);
        $attempts = $_SESSION[self::KEY][$key]['count'] ?? 0;
        return $attempts >= $maxAttempts;
    }

    public static function hit(string $key, int $decaySeconds): void
    {
        $now = time();
        if (!isset($_SESSION[self::KEY][$key])) {
            $_SESSION[self::KEY][$key] = ['count' => 0, 'start' => $now];
        }
        $_SESSION[self::KEY][$key]['count']++;
        // Ensure window start exists
        $_SESSION[self::KEY][$key]['start'] = $_SESSION[self::KEY][$key]['start'] ?? $now;
    }

    public static function clear(string $key): void
    {
        unset($_SESSION[self::KEY][$key]);
    }

    public static function availableIn(string $key, int $decaySeconds): int
    {
        if (!isset($_SESSION[self::KEY][$key]['start'])) return 0;
        $elapsed = time() - $_SESSION[self::KEY][$key]['start'];
        return max(0, $decaySeconds - $elapsed);
    }

    private static function cleanup(string $key, int $decaySeconds): void
    {
        if (!isset($_SESSION[self::KEY][$key]['start'])) return;
        $elapsed = time() - $_SESSION[self::KEY][$key]['start'];
        if ($elapsed >= $decaySeconds) {
            unset($_SESSION[self::KEY][$key]);
        }
    }
}
