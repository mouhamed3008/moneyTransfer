<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::get('/users', [UserController::class, 'index']);

Route::post('/user-create', [UserController::class, 'createUser']);

Route::post('/register', [AuthController::class, 'register']);


Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/transactions', [\App\Http\Controllers\TransactionController::class, 'index']);
});
