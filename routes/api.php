<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/user/login', [UserController::class, 'login']);
Route::post('/user/register', [UserController::class, 'register']);

Route::apiResource("/announcement", AnnouncementController::class)
    ->except(["show","index", "update"])
    ->middleware('auth:api');

// YEAH! I know I could use it in apiResource but put doesn't accept the image so... I had to do it this way
Route::post("/announcement-update/{id}", [AnnouncementController::class, "update"])
    ->middleware('auth:api');

// Not to override the previous route
Route::apiResource("/announcement-get", AnnouncementController::class)
    ->except(["show","index"]);
