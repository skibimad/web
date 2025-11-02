<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group.
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/blog', function () {
    return view('blog');
});

Route::get('/admin', function () {
    return view('admin.dashboard');
});

Route::get('/admin/heroes', function () {
    return view('admin.heroes');
});

Route::get('/admin/episodes', function () {
    return view('admin.episodes');
});

Route::get('/admin/blog', function () {
    return view('admin.blog');
});
