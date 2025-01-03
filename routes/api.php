<?php

use App\Helpers\ApiResponse;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Middleware\EnsureGuest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/users', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', LoginController::class)
    ->middleware(EnsureGuest::class);

Route::post('/logout', LogoutController::class)
    ->middleware('auth:sanctum');
