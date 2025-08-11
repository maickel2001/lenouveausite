<?php
namespace App\Models;

use PDO;

class User
{
    public static function findByEmail(PDO $pdo, string $email): ?array
    {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function create(PDO $pdo, string $name, string $email, string $password, string $role = 'client'): int
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO users (name, email, password_hash, role) VALUES (:name, :email, :password_hash, :role)');
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password_hash' => $hash,
            'role' => $role,
        ]);
        return (int)$pdo->lastInsertId();
    }
}
