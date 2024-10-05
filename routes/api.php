<?php

use Intrazero\AuthBoilerplate\Controllers\API\AuthController;
use Illuminate\Support\Facades\Route;

// User registration route
Route::post('/register', [AuthController::class, 'register']);

// User login route
Route::post('/login', [AuthController::class, 'login']);

// User logout route (requires authentication)
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
