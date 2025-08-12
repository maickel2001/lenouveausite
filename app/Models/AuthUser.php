<?php
namespace App\Models;

use PDO;

class AuthUser
{
    public static function register(PDO $pdo, string $name, string $email, string $password): int
    {
        $email = strtolower(trim($email));
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO users (name, email, password_hash, role) VALUES (:name, :email, :password_hash, :role)');
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password_hash' => $hash,
            'role' => 'client',
        ]);
        return (int)$pdo->lastInsertId();
    }

    public static function verifyCredentials(PDO $pdo, string $email, string $password): ?array
    {
        $email = strtolower(trim($email));
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        if (!$user) { return null; }
        if (!password_verify($password, $user['password_hash'])) { return null; }
        return $user;
    }
}
