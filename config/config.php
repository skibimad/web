<?php
return [
    'debug' => true,
    //'domain' => 'https://portal.aghawkdynamics.com/',
    'date_format' => 'm/d/Y',
    'root' => __DIR__ . '/../',
    
    'db' => [
        'host' => 'localhost',
        'port' => 3306,
        'user' => 'root',
        'password' => 'smxksmxkmM1@',
        'database_name' => 'skibidi_madness'
    ],
    'upload_dir' => '/public/uploads/',

    'max_upload_size' => 10485760, // 10 MB

    // Global middleware configuration
    'middleware' => [
        // Global middleware that runs for all requests
        'global' => [
            // Add global middleware here
            // Example: \App\Middleware\CorsMiddleware::class,
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
