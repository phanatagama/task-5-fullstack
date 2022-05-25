<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Api\v1\PostController;
use App\Http\Controllers\Api\v1\ArticlesController;
use App\Http\Controllers\Api\v1\CategoriesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/v1/user', function (Request $request) {
    return $request->user();
});

Route::post('/v1/register', [RegisterController::class, 'register']);
Route::post('/v1/login', [LoginController::class, 'login'])->name('login');
Route::post('/v1/logout', [LoginController::class, 'logout'])->middleware('auth:api');
// Route::apiResource('/users', [PostController::class]);
Route::apiResource('/v1/articles', ArticlesController::class)->middleware('auth:api');
Route::apiResource('/v1/categories', CategoriesController::class)->middleware('auth:api');