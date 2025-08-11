<?php
use App\Core\Router;
use App\Core\View;
use App\Helpers\Session;
use App\Helpers\Auth;

// Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = dirname(__DIR__) . '/app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

// Load config
$config = require dirname(__DIR__) . '/config/config.php';

// Start session
Session::start();

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
