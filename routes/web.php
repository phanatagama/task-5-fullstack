<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/home');
});

Auth::routes();
// Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/articles/create', [App\Http\Controllers\HomeController::class, 'create']);
Route::post('/articles/create', [App\Http\Controllers\HomeController::class, 'store']);
Route::get('/articles/edit/{id}', [App\Http\Controllers\HomeController::class, 'edit']);
Route::delete('/articles/{id}', [App\Http\Controllers\HomeController::class,'destroy']);
Route::put('/articles/edit/{id}', [App\Http\Controllers\HomeController::class, 'update']);
