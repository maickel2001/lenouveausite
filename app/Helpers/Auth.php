<?php
namespace App\Helpers;

class Auth
{
    public static function check(): bool
    {
        return (bool) Session::get('user_id');
    }

    public static function id(): ?int
    {
        return Session::get('user_id');
    }

    public static function userRole(): string
    {
        return Session::get('user_role', 'guest');
    }

    public static function isAdmin(): bool
    {
        return self::userRole() === 'admin';
    }

    public static function login(int $userId, string $role = 'client'): void
    {
        Session::set('user_id', $userId);
        Session::set('user_role', $role);
    }

    public static function logout(): void
    {
        Session::remove('user_id');
        Session::remove('user_role');
    }
}
