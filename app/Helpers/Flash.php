<?php
namespace App\Helpers;

class Flash
{
    private const KEY = '_flash';

    public static function add(string $type, string $message): void
    {
        if (!isset($_SESSION[self::KEY])) {
            $_SESSION[self::KEY] = [];
        }
        $_SESSION[self::KEY][$type][] = $message;
    }

    public static function get(string $type): array
    {
        $all = $_SESSION[self::KEY][$type] ?? [];
        // Clear after reading
        unset($_SESSION[self::KEY][$type]);
        return $all;
    }

    public static function all(): array
    {
        $messages = $_SESSION[self::KEY] ?? [];
        unset($_SESSION[self::KEY]);
        return $messages;
    }

    public static function has(): bool
    {
        return !empty($_SESSION[self::KEY]);
    }
}
