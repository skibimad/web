<?php

/**
 * Front Controller - Entry point for all requests
 */

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
