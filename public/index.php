<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Load configuration to determine debug mode
$debug = getenv('APP_DEBUG') === 'true' ? true : false;

if ($debug) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
}

\App\Core\Error\ErrorHandler::init();
\App\Core\Helper\Resource::init(__DIR__ . '/..');

$app = \App\Core\App::getInstance();

$app->run();
