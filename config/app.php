<?php

return [
    'app_name' => 'Skibidi Madness',
    'app_url' => getenv('APP_URL') ?: 'http://localhost',
    'base_path' => dirname(__DIR__),
    'public_path' => dirname(__DIR__) . '/public',
    'uploads_path' => dirname(__DIR__) . '/uploads',
    'views_path' => dirname(__DIR__) . '/app/Views',
    
    'session' => [
        'lifetime' => 120, // minutes
        'cookie_name' => 'skibidi_session',
    ],
    
    'admin' => [
        'default_user' => 'fsx',
        'default_password' => '111111', // Will be hashed
    ],
    
    'youtube_channel' => 'https://www.youtube.com/@FirestomX-Tri',
];
