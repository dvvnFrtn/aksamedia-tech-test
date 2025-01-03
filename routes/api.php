<?php

use App\Http\Controllers\DivisionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Middleware\EnsureGuest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/users', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', LoginController::class)
    ->middleware(EnsureGuest::class);

Route::post('/logout', LogoutController::class)
    ->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function() {
        Route::get('/divisions', DivisionController::class);
        Route::get('/employees', [EmployeeController::class, 'index']);
        Route::post('/employees', [EmployeeController::class, 'store']);
        Route::put('/employees/{uuid}', [EmployeeController::class, 'update']);
        Route::delete('/employees/{uuid}', [EmployeeController::class, 'destroys']);
    }
);