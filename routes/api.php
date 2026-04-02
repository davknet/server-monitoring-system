<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/auth/login', [AuthController::class, 'apiLogin'])->name('api.login');

Route::middleware('auth:sanctum')->group(function () {


    Route::get('/auth/servers'        , [\App\Http\Controllers\Api\ServerController::class, 'index']);
    Route::post('/auth/server/create',  [\App\Http\Controllers\Api\ServerController::class, 'store']);
    Route::put('/auth/server/{id}/update',  [\App\Http\Controllers\Api\ServerController::class, 'update']);
    Route::delete('/auth/server/{id}/delete',  [\App\Http\Controllers\Api\ServerController::class, 'destroy']);

});





