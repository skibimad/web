<?php

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
    $router->get('/', 'HomeController@index');
    
    // Blog
    $router->get('/blog', 'BlogController@index');
    $router->get('/blog/{slug}', 'BlogController@show');
    
    
    // ============================================
    // ADMIN ROUTES
    // ============================================
    
    // Auth
    $router->get('/admin/login', 'AuthController@showLogin');
    $router->post('/admin/login', 'AuthController@login');
    $router->get('/admin/logout', 'AuthController@logout');
    
    // Dashboard
    $router->get('/admin', 'DashboardController@index', ['auth']);
    $router->post('/admin/change-password', 'DashboardController@changePassword', ['auth']);
    
    // Heroes
    $router->get('/admin/heroes', 'HeroController@index', ['auth']);
    $router->get('/admin/heroes/create', 'HeroController@create', ['auth']);
    $router->post('/admin/heroes', 'HeroController@store', ['auth']);
    $router->get('/admin/heroes/{id}/edit', 'HeroController@edit', ['auth']);
    $router->post('/admin/heroes/{id}', 'HeroController@update', ['auth']);
    $router->post('/admin/heroes/{id}/delete', 'HeroController@delete', ['auth']);
    
    // Episodes
    $router->get('/admin/episodes', 'EpisodeController@index', ['auth']);
    $router->get('/admin/episodes/create', 'EpisodeController@create', ['auth']);
    $router->post('/admin/episodes', 'EpisodeController@store', ['auth']);
    $router->get('/admin/episodes/{id}/edit', 'EpisodeController@edit', ['auth']);
    $router->post('/admin/episodes/{id}', 'EpisodeController@update', ['auth']);
    $router->post('/admin/episodes/{id}/delete', 'EpisodeController@delete', ['auth']);
    
    // Blog Admin
    $router->get('/admin/blog', 'BlogAdminController@index', ['auth']);
    $router->get('/admin/blog/create', 'BlogAdminController@create', ['auth']);
    $router->post('/admin/blog', 'BlogAdminController@store', ['auth']);
    $router->get('/admin/blog/{id}/edit', 'BlogAdminController@edit', ['auth']);
    $router->post('/admin/blog/{id}', 'BlogAdminController@update', ['auth']);
    $router->post('/admin/blog/{id}/delete', 'BlogAdminController@delete', ['auth']);
    
    // Content Editor
    $router->get('/admin/content', 'ContentController@index', ['auth']);
    $router->post('/admin/content', 'ContentController@update', ['auth']);
    
    // File Upload
    $router->post('/admin/upload', 'UploadController@upload', ['auth']);
};
