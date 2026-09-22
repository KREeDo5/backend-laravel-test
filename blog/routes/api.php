<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Api\Controllers\AuthController;
use App\Http\Api\Controllers\PostController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

// Публикации
// -- Список публикаций (без обязательной авторизации)
Route::get('/posts', [PostController::class, 'index']);

// - Список публикаций (c обязательной авторизацией)
Route::middleware('auth:sanctum')->group(function (): void {
    // -- Создание публикации
    Route::post('/posts', [PostController::class, 'create']);
    // -- Публикации текущего пользователя
    Route::get('/my-posts', [PostController::class, 'myPosts']);
});