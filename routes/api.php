<?php

use App\Http\Controllers\Api\Auth\Sanctum\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\Sanctum\LoginController;
use App\Http\Controllers\Api\Auth\Sanctum\ResetPasswordController;
use App\Http\Controllers\BookController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('/auth/basic')->middleware('auth.basic')->group(function () {
    Route::get('users', function () {
        return User::all();
    });
});

Route::prefix('/sanctum')->group(function () {

    Route::post('login', [LoginController::class, 'login']);

    // Reset password
    Route::post('forgot-password', ForgotPasswordController::class);
    Route::post('reset-password', ResetPasswordController::class);

    // Protected routes auth:sanctum
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('users', function () {
            return User::all();
        })->middleware(['permission:users.list']);

        Route::post('logout', [LoginController::class, 'logout']);
        Route::apiResource('books', BookController::class);

    });
});

Route::prefix('/passport')->group(function () {

    Route::post('login', [LoginController::class, 'login']);

    // Reset password
    Route::post('forgot-password', ForgotPasswordController::class);
    Route::post('reset-password', ResetPasswordController::class);

    // Protected routes auth:passport
    Route::middleware('auth:passport')->group(function () {
        Route::get('users', function () {
            return User::all();
        })->middleware(['permission:users.list']);

        Route::post('logout', [LoginController::class, 'logout']);
        Route::apiResource('books', BookController::class);

    });
});
