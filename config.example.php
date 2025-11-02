<?php
// Database Configuration
// Copy this file to config.php and update with your database credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'skibidi_madness');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Application Settings
define('APP_NAME', 'Skibidi Madness');
define('BASE_URL', '');  // Leave empty for auto-detection or set your domain
define('UPLOAD_DIR', __DIR__ . '/uploads/');
define('UPLOAD_URL', '/uploads/');

// Session Settings
define('SESSION_NAME', 'skibidi_admin');
define('SESSION_LIFETIME', 7200); // 2 hours

// Timezone
date_default_timezone_set('UTC');

// Error Reporting (set to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
