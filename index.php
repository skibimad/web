<?php

/**
 * Front Controller - Entry point for all requests
 */

// Load .env file if it exists
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        
        if (!array_key_exists($name, $_ENV)) {
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}

// Error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Require Composer autoloader
require __DIR__ . '/vendor/autoload.php';

// Import required classes
use App\Core\Request;
use App\Core\Router;
use App\Core\ErrorHandler;

// Register error handlers
ErrorHandler::register();

// Create request object
$request = new Request();

// Create router and dispatch
$router = new Router($request);
$router->dispatch();
