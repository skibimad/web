<?php
/**
 * Application Configuration
 */

// Database configuration
define('DB_PATH', __DIR__ . '/../database/skibidi_madness.db');

// Application settings
define('APP_NAME', 'Skibidi Madness');
define('BASE_URL', '/');
define('ADMIN_URL', '/admin/');

// Upload settings
define('UPLOAD_DIR', __DIR__ . '/../uploads/');
define('MAX_UPLOAD_SIZE', 10 * 1024 * 1024); // 10MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
define('ALLOWED_VIDEO_TYPES', ['video/mp4']);

// Session settings
define('SESSION_TIMEOUT', 24 * 60 * 60); // 24 hours
define('SESSION_NAME', 'skibidi_session');

// Security settings
define('PASSWORD_HASH_ALGO', PASSWORD_BCRYPT);
define('PASSWORD_HASH_COST', 12);

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone
date_default_timezone_set('UTC');

// Start session
session_name(SESSION_NAME);
session_start();
