<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ConsultationController;
use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\RequestController;

// Public Route - 
Route::post('/consultation-request', [ConsultationController::class, 'store']);

// Admin Authentication
Route::prefix('admin')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    
    // Protected Admin Routes
    Route::middleware('admin.token')->group(function () {
        Route::get('/requests', [RequestController::class, 'index']);
        Route::delete('/requests/{id}', [RequestController::class, 'destroy']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});