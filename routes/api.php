<?php

use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\HeroController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group.
|
*/

// Heroes API
Route::apiResource('heroes', HeroController::class);

// Episodes API
Route::apiResource('episodes', EpisodeController::class);

// Blog Posts API
Route::apiResource('blog-posts', BlogPostController::class);
Route::get('blog-posts-recent', [BlogPostController::class, 'recent']);
