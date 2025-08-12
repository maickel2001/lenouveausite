<?php
namespace App\Helpers;

class Csrf
{
    public static function token(): string
    {
        if (!isset($_SESSION['_csrf'])) {
            $_SESSION['_csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf'];
    }

    public static function field(): string
    {
        $token = self::token();
        return '<input type="hidden" name="_csrf" value="' . htmlspecialchars($token, ENT_QUOTES) . '">';
    }

    public static function validate(?string $token): bool
    {
        return isset($_SESSION['_csrf']) && hash_equals($_SESSION['_csrf'], $token ?? '');
    }
}
