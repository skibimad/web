<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Skibidi Madness Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration options for the Skibidi Madness package
    |
    */

    // Enable/disable specific features
    'features' => [
        'heroes' => true,
        'episodes' => true,
        'blog' => true,
        'admin_panel' => true,
    ],

    // API configuration
    'api' => [
        'prefix' => 'api',
        'middleware' => ['api'],
    ],

    // Frontend configuration
    'frontend' => [
        'languages' => ['en', 'es', 'fr', 'de'],
        'default_language' => 'en',
    ],

    // Media paths
    'media' => [
        'heroes_path' => 'res/img/heroes/promo',
        'heroes_video_path' => 'res/video/heroes/promo',
        'episodes_path' => 'res/img',
        'blog_images_path' => 'res/img',
    ],

    // Pagination
    'pagination' => [
        'heroes_per_page' => 10,
        'episodes_per_page' => 10,
        'blog_posts_per_page' => 10,
        'recent_blog_posts' => 3,
    ],

];
