<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentTypeController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DashboardController;

// Debug simple
Route::get('/debug-api', function () {
    return response()->json(['message' => 'API is working correctly!']);
});

// Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Routes protégées (middleware auth:sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::middleware('auth:sanctum')->get('/stats', [DashboardController::class, 'stats']);
    // Marquer une notification comme lue
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::put('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::apiResource('document-types', DocumentTypeController::class);
    Route::get('/document-types/{id}/documents', [DocumentTypeController::class, 'index']);
    Route::apiResource('demandes', DemandeController::class);
    
});