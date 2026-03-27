<?php

use Illuminate\Support\Facades\Route;
Route::middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
    Route::get('/create-server', [App\Http\Controllers\CreateServerController::class, 'index'])->name('create-server');




});



Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLogin'])
    ->middleware('guest')
    ->name('login');;

Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])
    ->middleware('guest');





