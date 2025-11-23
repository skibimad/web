<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/../vendor/autoload.php';

\App\Core\Error\ErrorHandler::init();
\App\Core\Helper\Resource::init(__DIR__ . '/..');

$app = \App\Core\App::getInstance();

$app->run();
