<?php

// Bootstrap file
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/Helpers/functions.php';

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use App\Core\Router;
use App\Core\Request;
use App\Core\Response;
use App\Middleware\AuthMiddleware;

// Create instances
$router = new Router();
$request = new Request();
$response = new Response();

// Public routes
$router->get('/', 'HomeController@index');
$router->get('/blog', 'HomeController@blog');

// Admin authentication routes
$router->get('/admin/login', 'AdminController@login');
$router->post('/admin/login', 'AdminController@login');
$router->get('/admin/logout', 'AdminController@logout');

// Protected admin routes
$router->get('/admin', 'AdminController@dashboard', [AuthMiddleware::class]);
$router->get('/admin/dashboard', 'AdminController@dashboard', [AuthMiddleware::class]);
$router->get('/admin/change-password', 'AdminController@changePassword', [AuthMiddleware::class]);
$router->post('/admin/change-password', 'AdminController@changePassword', [AuthMiddleware::class]);

// Admin Heroes
$router->get('/admin/heroes', 'AdminHeroController@index', [AuthMiddleware::class]);
$router->get('/admin/heroes/create', 'AdminHeroController@create', [AuthMiddleware::class]);
$router->post('/admin/heroes/create', 'AdminHeroController@create', [AuthMiddleware::class]);
$router->get('/admin/heroes/edit/{id}', 'AdminHeroController@edit', [AuthMiddleware::class]);
$router->post('/admin/heroes/edit/{id}', 'AdminHeroController@edit', [AuthMiddleware::class]);
$router->get('/admin/heroes/delete/{id}', 'AdminHeroController@delete', [AuthMiddleware::class]);

// Admin Episodes
$router->get('/admin/episodes', 'AdminEpisodeController@index', [AuthMiddleware::class]);
$router->get('/admin/episodes/create', 'AdminEpisodeController@create', [AuthMiddleware::class]);
$router->post('/admin/episodes/create', 'AdminEpisodeController@create', [AuthMiddleware::class]);
$router->get('/admin/episodes/edit/{id}', 'AdminEpisodeController@edit', [AuthMiddleware::class]);
$router->post('/admin/episodes/edit/{id}', 'AdminEpisodeController@edit', [AuthMiddleware::class]);
$router->get('/admin/episodes/delete/{id}', 'AdminEpisodeController@delete', [AuthMiddleware::class]);

// Admin Blog
$router->get('/admin/blog', 'AdminBlogController@index', [AuthMiddleware::class]);
$router->get('/admin/blog/create', 'AdminBlogController@create', [AuthMiddleware::class]);
$router->post('/admin/blog/create', 'AdminBlogController@create', [AuthMiddleware::class]);
$router->get('/admin/blog/edit/{id}', 'AdminBlogController@edit', [AuthMiddleware::class]);
$router->post('/admin/blog/edit/{id}', 'AdminBlogController@edit', [AuthMiddleware::class]);
$router->get('/admin/blog/delete/{id}', 'AdminBlogController@delete', [AuthMiddleware::class]);

// Admin Landing Page
$router->get('/admin/landing', 'AdminLandingController@index', [AuthMiddleware::class]);
$router->post('/admin/landing', 'AdminLandingController@update', [AuthMiddleware::class]);

// Dispatch the router
try {
    $router->dispatch($request, $response);
} catch (Exception $e) {
    http_response_code(500);
    echo "Error: " . $e->getMessage();
}
