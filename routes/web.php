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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('/statistics', 'App\Http\Controllers\StatisticController');

Route::get('/statistics/admin/all', [App\Http\Controllers\StatisticController::class, 'listAll'])->name('statistics.all');

Route::get('/message', [App\Http\Controllers\MessageController::class, 'createReminder'])->name('message');

Route::get('/users/all', [App\Http\Controllers\UserController::class, 'index'])->name('users.all');

Route::put('/users/activate/{user}', [App\Http\Controllers\UserController::class, 'activate'])->name('users.activate');

Route::put('/users/deactivate/{user}', [App\Http\Controllers\UserController::class, 'deactivate'])->name('users.deactivate');
