<?php

use App\Http\Controllers\Api\ServerController;
use App\Http\Controllers\CreateServerController;
use App\Http\Controllers\ServerWebController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
    Route::get('/create-server', [CreateServerController::class, 'index'])->name('create-server');
    Route::post('/add-server', [ServerWebController::class, 'store'])->name('servers.store');
});



Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLogin'])
    ->middleware('guest')
    ->name('login');;

Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])
    ->middleware('guest');





