<?php

/**
 * Helper functions
 */

if (!function_exists('config')) {
    function config($key, $default = null)
    {
        static $config = null;
        
        if ($config === null) {
            $config = require __DIR__ . '/../config/app.php';
        }
        
        return $config[$key] ?? $default;
    }
}

if (!function_exists('asset')) {
    function asset($path)
    {
        return '/' . ltrim($path, '/');
    }
}

if (!function_exists('url')) {
    function url($path = '')
    {
        $baseUrl = config('app_url', 'http://localhost');
        return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
    }
}

if (!function_exists('escape')) {
    function escape($value)
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('old')) {
    function old($key, $default = '')
    {
        return $_SESSION['old'][$key] ?? $default;
    }
}
