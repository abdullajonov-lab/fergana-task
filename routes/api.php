<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/user/login', [UserController::class, 'login']);
Route::post('/user/register', [UserController::class, 'register']);

Route::apiResource("/announcement", AnnouncementController::class)
    ->except(["show","index"])
    ->middleware('auth:api');

// Not to override the previous route
Route::apiResource("/announcement-get", AnnouncementController::class)
    ->except(["show","index"]);
