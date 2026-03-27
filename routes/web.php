<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\Homecontroller::class, 'index']);


Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLogin']);
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout']);




