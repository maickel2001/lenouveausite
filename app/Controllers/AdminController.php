<?php
namespace App\Controllers;

use App\Core\View;
use App\Helpers\Auth;

class AdminController
{
    public static function dashboard()
    {
        if (!Auth::isAdmin()) {
            http_response_code(403);
            echo 'Forbidden';
            return null;
        }
        return View::render('admin/dashboard');
    }
}
