<?php

/**
 * Public Front Controller
 * Single entry point for all public pages
 */

// Define paths
define('ROOT_PATH', dirname(__DIR__));
define('PUBLIC_PATH', __DIR__);

// Load Composer's autoloader
require_once ROOT_PATH . '/vendor/autoload.php';

// Run application
use Core\Application;

$app = Application::getInstance();
$app->run();
