<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
        Route::get('profile', [\App\Http\Controllers\AuthController::class, 'profile']);
    });
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('categories', \App\Http\Controllers\CategoryController::class)->except('update');
    Route::post('categories/{category}', [\App\Http\Controllers\CategoryController::class, 'update']);
    Route::apiResource('reminders', \App\Http\Controllers\ReminderController::class)->except('update');
    Route::post('reminders/{reminder}', [\App\Http\Controllers\ReminderController::class, 'update']);
    Route::post('reminders/{reminder}/done', [\App\Http\Controllers\ReminderController::class, 'done']);
    Route::post('reminders/{reminder}/important', [\App\Http\Controllers\ReminderController::class, 'important']);

    Route::group(['middleware' => 'role:admin'], function () {
        Route::apiResource('users', \App\Http\Controllers\UserController::class)->except('update');
        Route::post('users/{user}', [\App\Http\Controllers\UserController::class, 'update']);
        Route::post('users/{user}/update-password', [\App\Http\Controllers\UserController::class, 'updatePassword']);
    });
});
