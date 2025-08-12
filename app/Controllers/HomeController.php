<?php
namespace App\Controllers;

use App\Core\View;

class HomeController
{
    public static function index()
    {
        return View::render('pages/home', []);
    }
}
