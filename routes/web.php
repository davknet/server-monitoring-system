<?php

use App\Http\Controllers\Api\ServerController;
use App\Http\Controllers\CreateServerController;
use App\Http\Controllers\Homecontroller;
use App\Http\Controllers\ServerWebController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/home', [App\Http\Controllers\Homecontroller::class, 'index'])->name('home');
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
    Route::get('/create-server', [CreateServerController::class, 'index'])->name('create-server');
    Route::post('/add-server', [ServerWebController::class, 'store'])->name('servers.store');
    Route::get('/update-server', [CreateServerController::class, 'update'])->name('update-server');
    Route::get('/servers/{server}/edit', [ServerWebController::class, 'update'])->name('servers.edit');
    Route::delete('/servers/{server}', [ServerWebController::class , 'destroy'])->name('servers.destroy');
    Route::put('/server/{server}/save', [ServerWebController::class, 'save'])->name('servers.save');
    Route::get('/servers/search', [ServerWebController::class, 'search'])->name('servers.search');

});

Route::get('/server-tests', [Homecontroller::class, 'serverTests'])->name('server-tests');

Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLogin'])
    ->middleware('guest')
    ->name('login');;

Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])
    ->middleware('guest');





