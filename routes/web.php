<?php

use Illuminate\Support\Facades\Route;
Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout']);


});



Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLogin']);

Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);





