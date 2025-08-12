<?php
namespace App\Controllers;

use App\Core\View;
use App\Helpers\Auth;
use App\Helpers\Csrf;
use App\Helpers\Flash;
use App\Helpers\Throttle;
use App\Core\Database;
use App\Models\AuthUser;

class AuthController
{
    public static function loginForm()
    {
        return View::render('auth/login');
    }

    public static function login()
    {
        if (!Csrf::validate($_POST['_csrf'] ?? null)) {
            http_response_code(400);
            echo 'Invalid CSRF token';
            return null;
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $key = 'login:' . sha1($_SERVER['REMOTE_ADDR'] ?? 'cli');
        $maxAttempts = 5; $decay = 60; // 5 attempts per 60s
        if (Throttle::tooManyAttempts($key, $maxAttempts, $decay)) {
            $wait = Throttle::availableIn($key, $decay);
            Flash::add('error', "Trop de tentatives. Réessayez dans {$wait}s.");
            header('Location: /login');
            return null;
        }

        $app = require dirname(__DIR__, 2) . '/bootstrap.php';
        $pdo = Database::connection($app['config']['db']);
        if (!$pdo) {
            Flash::add('error', 'Erreur serveur: connexion DB.');
            header('Location: /login');
            return null;
        }

        $user = AuthUser::verifyCredentials($pdo, $email, $password);
        if (!$user) {
            Throttle::hit($key, $decay);
            Flash::add('error', 'Identifiants invalides.');
            header('Location: /login');
            return null;
        }

        Throttle::clear($key);
        Auth::login((int)$user['id'], $user['role'] ?? 'client');
        Flash::add('success', 'Connexion réussie.');
        header('Location: ' . ($user['role'] === 'admin' ? '/admin' : '/'));
        return null;
    }

    public static function registerForm()
    {
        return View::render('auth/register');
    }

    public static function register()
    {
        if (!Csrf::validate($_POST['_csrf'] ?? null)) {
            http_response_code(400);
            echo 'Invalid CSRF token';
            return null;
        }
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // Basic validations
        $errors = [];
        if ($name === '' || mb_strlen($name) < 2) { $errors[] = 'Nom invalide.'; }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors[] = 'Email invalide.'; }
        if (mb_strlen($password) < 8) { $errors[] = 'Mot de passe trop court (min. 8 caractères).'; }

        $app = require dirname(__DIR__, 2) . '/bootstrap.php';
        $pdo = Database::connection($app['config']['db']);
        if (!$pdo) {
            $errors[] = 'Erreur serveur: connexion DB.';
        }

        if (empty($errors)) {
            // Ensure unique email
            $stmt = $pdo->prepare('SELECT 1 FROM users WHERE email = :email LIMIT 1');
            $stmt->execute(['email' => strtolower($email)]);
            if ($stmt->fetch()) {
                $errors[] = 'Un compte existe déjà avec cet email.';
            }
        }

        if (!empty($errors)) {
            foreach ($errors as $err) { Flash::add('error', $err); }
            header('Location: /register');
            return null;
        }

        $userId = AuthUser::register($pdo, $name, $email, $password);
        Auth::login($userId, 'client');
        Flash::add('success', 'Compte créé avec succès.');
        header('Location: /');
        return null;
    }

    public static function logout()
    {
        Auth::logout();
        Flash::add('success', 'Vous êtes déconnecté.');
        header('Location: /');
        return null;
    }
}
