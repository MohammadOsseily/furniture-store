<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'register']); // User Registration
    Route::post('/login', [AuthController::class, 'login']);       // User Login
    Route::post('/logout', [AuthController::class, 'logout']);     // User Logout
    Route::post('/refresh', [AuthController::class, 'refresh']);   // Refresh Token
});

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/user/profile', [UserController::class, 'profile']);              // Get User Profile
    Route::post('/user/profile/update', [UserController::class, 'updateProfile']); // Update User Profile
});

