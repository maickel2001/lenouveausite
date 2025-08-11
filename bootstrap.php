<?php
use App\Helpers\Session;

// PSR-4 like autoloader for App\\ namespace
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/app/';
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
$config = require __DIR__ . '/config/config.php';

// Start session for web contexts only
if (PHP_SAPI !== 'cli') {
    Session::start();
}

return ['config' => $config];
