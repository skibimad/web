<?php
return [
    'debug' => getenv('APP_DEBUG') === 'true',
    'date_format' => 'm/d/Y',
    'root' => realpath(__DIR__ . '/../').'/',
    
    'db' => [
        'host' => getenv('DB_HOST') ?: 'localhost',
        'port' => (int)(getenv('DB_PORT') ?: 3306),
        'user' => getenv('DB_USER') ?: 'root',
        'password' => getenv('DB_PASSWORD') ?: '',
        'database_name' => getenv('DB_NAME') ?: 'skibidi_madness'
    ],
    'upload_dir' => '/uploads/',

    'max_upload_size' => 10485760, // 10 MB

    // Global middleware configuration
    'middleware' => [
        // Global middleware that runs for all requests
        'global' => [
            \App\Middleware\SecurityHeadersMiddleware::class,
        ],
        
        // Middleware groups for different areas
        'groups' => [
            // Admin area middleware
            'admin' => [
                \App\Middleware\AuthMiddleware::class,
            ],
            
            // Frontend middleware
            'frontend' => [
                // Add frontend-specific middleware here
            ],
        ],
    ],
];
