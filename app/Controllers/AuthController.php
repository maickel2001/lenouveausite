<?php
namespace App\Controllers;

use App\Core\View;
use App\Helpers\Auth;
use App\Helpers\Csrf;

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
        // Placeholder: accept any email/password and set client role
        Auth::login(1, 'admin'); // For demo, log as admin; replace with real check later
        header('Location: /admin');
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
        // Placeholder registration success
        header('Location: /login');
        return null;
    }

    public static function logout()
    {
        Auth::logout();
        header('Location: /');
        return null;
    }
}
