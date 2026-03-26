<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ConsultationController;
use App\Http\Controllers\Api\AdminController;

// Public Route - استقبال الطلبات
Route::post('/consultation-request', [ConsultationController::class, 'store']);

// Admin Secret Route - رابط سري للأدمن
Route::prefix('safwa-admin-2024-secret')->group(function () {
    Route::get('/requests', [AdminController::class, 'index']);
    Route::get('/requests/{id}', [AdminController::class, 'show']);
    Route::delete('/requests/{id}', [AdminController::class, 'destroy']);
});