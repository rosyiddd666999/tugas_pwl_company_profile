<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../app/core/' . $class . '.php',
        __DIR__ . '/../app/controllers/' . $class . '.php',
        __DIR__ . '/../app/models/' . $class . '.php',
        __DIR__ . '/../config/' . $class . '.php',
    ];
    foreach ($paths as $file) {
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

$router = require_once __DIR__ . '/../app/core/routes.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (defined('BASE_PATH') && BASE_PATH !== '' && BASE_PATH !== '/') {
    if (strpos($uri, BASE_PATH) === 0) {
        $uri = substr($uri, strlen(BASE_PATH));
        if ($uri === '') $uri = '/';
    }
}

$router->dispatch($method, $uri);
