<?php

/**
 * Public Front Controller
 * Single entry point for all public pages
 */

// Define paths
define('ROOT_PATH', dirname(__DIR__));
define('PUBLIC_PATH', __DIR__);

// Load application bootstrap
require_once ROOT_PATH . '/core/Application.php';

// Run application
$app = Application::getInstance();
$app->run();
