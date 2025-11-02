<?php

use Core\Security;
use Core\Response;

/**
 * Route Configuration
 */

return function($router) {
    
    // Register middleware
    $router->middleware('auth', function($request) {
        if (!Security::isAuthenticated()) {
            Response::redirect('/admin/login');
        }
    });
    
    // ============================================
    // PUBLIC ROUTES
    // ============================================
    
    // Home page
    $router->get('/', 'App\Controllers\HomeController@index');
    
    // Blog
    $router->get('/blog', 'App\Controllers\BlogController@index');
    $router->get('/blog/{slug}', 'App\Controllers\BlogController@show');
    
    
    // ============================================
    // ADMIN ROUTES
    // ============================================
    
    // Auth
    $router->get('/admin/login', 'App\Controllers\AuthController@showLogin');
    $router->post('/admin/login', 'App\Controllers\AuthController@login');
    $router->get('/admin/logout', 'App\Controllers\AuthController@logout');
    
    // Dashboard
    $router->get('/admin', 'App\Controllers\DashboardController@index', ['auth']);
    $router->post('/admin/change-password', 'App\Controllers\DashboardController@changePassword', ['auth']);
    
    // Heroes
    $router->get('/admin/heroes', 'App\Controllers\HeroController@index', ['auth']);
    $router->get('/admin/heroes/create', 'App\Controllers\HeroController@create', ['auth']);
    $router->post('/admin/heroes', 'App\Controllers\HeroController@store', ['auth']);
    $router->get('/admin/heroes/{id}/edit', 'App\Controllers\HeroController@edit', ['auth']);
    $router->post('/admin/heroes/{id}', 'App\Controllers\HeroController@update', ['auth']);
    $router->post('/admin/heroes/{id}/delete', 'App\Controllers\HeroController@delete', ['auth']);
    
    // Episodes
    $router->get('/admin/episodes', 'App\Controllers\EpisodeController@index', ['auth']);
    $router->get('/admin/episodes/create', 'App\Controllers\EpisodeController@create', ['auth']);
    $router->post('/admin/episodes', 'App\Controllers\EpisodeController@store', ['auth']);
    $router->get('/admin/episodes/{id}/edit', 'App\Controllers\EpisodeController@edit', ['auth']);
    $router->post('/admin/episodes/{id}', 'App\Controllers\EpisodeController@update', ['auth']);
    $router->post('/admin/episodes/{id}/delete', 'App\Controllers\EpisodeController@delete', ['auth']);
    
    // Blog Admin
    $router->get('/admin/blog', 'App\Controllers\BlogAdminController@index', ['auth']);
    $router->get('/admin/blog/create', 'App\Controllers\BlogAdminController@create', ['auth']);
    $router->post('/admin/blog', 'App\Controllers\BlogAdminController@store', ['auth']);
    $router->get('/admin/blog/{id}/edit', 'App\Controllers\BlogAdminController@edit', ['auth']);
    $router->post('/admin/blog/{id}', 'App\Controllers\BlogAdminController@update', ['auth']);
    $router->post('/admin/blog/{id}/delete', 'App\Controllers\BlogAdminController@delete', ['auth']);
    
    // Content Editor
    $router->get('/admin/content', 'App\Controllers\ContentController@index', ['auth']);
    $router->post('/admin/content', 'App\Controllers\ContentController@update', ['auth']);
    
    // File Upload
    $router->post('/admin/upload', 'App\Controllers\UploadController@upload', ['auth']);
};
