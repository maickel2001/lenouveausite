<?php
use App\Core\Router;
use App\Core\View;
use App\Helpers\Auth;

// Bootstrap (autoloader + config + session for web)
$app = require dirname(__DIR__) . '/bootstrap.php';
$config = $app['config'];

// Maintenance mode (except for admins)
$uri = $_SERVER['REQUEST_URI'] ?? '/';
if (($config['maintenance'] ?? false) && !Auth::isAdmin()) {
    http_response_code(503);
    View::render('errors/maintenance', ['config' => $config]);
    exit;
}

$router = new Router();

// Routes
$router->get('/', fn() => App\Controllers\HomeController::index());
$router->get('/login', fn() => App\Controllers\AuthController::loginForm());
$router->post('/login', fn() => App\Controllers\AuthController::login());
$router->get('/register', fn() => App\Controllers\AuthController::registerForm());
$router->post('/register', fn() => App\Controllers\AuthController::register());
$router->get('/logout', fn() => App\Controllers\AuthController::logout());
$router->get('/admin', fn() => App\Controllers\AdminController::dashboard());

// Dispatch
$router->dispatch($_SERVER['REQUEST_METHOD'] ?? 'GET', $uri);
