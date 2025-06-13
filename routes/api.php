<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Sales\DashboardController;
use App\Http\Controllers\Api\Sales\EventController;
use App\Http\Controllers\Api\Sales\DailyActivityController;
use App\Http\Controllers\Api\Sales\ClientController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public routes
Route::post('/login', [AuthController::class, 'login']);

// Test endpoint without authentication
Route::get('/test', function () {
    return response()->json([
        'message' => 'API is working!',
        'timestamp' => now()
    ]);
});

// Test sales endpoint without authentication
Route::get('/sales/test', function () {
    return response()->json([
        'message' => 'Sales API is working!',
        'timestamp' => now()
    ]);
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    
    // Sales API Routes (temporarily without role middleware for testing)
    Route::prefix('sales')->group(function () {
        // Dashboard
        Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
        
        // Events
        Route::get('/events/upcoming', [EventController::class, 'upcoming']);
        Route::get('/events/my-upcoming', [EventController::class, 'myUpcoming']);
        Route::get('/events/past', [EventController::class, 'past']);
        Route::get('/events/stats', [EventController::class, 'stats']);
        
        // Daily Activities
        Route::get('/daily-activity/recent', [DailyActivityController::class, 'recent']);
        Route::get('/daily-activity', [DailyActivityController::class, 'index']);
        Route::post('/daily-activity', [DailyActivityController::class, 'store']);
        Route::get('/daily-activity/{dailyActivity}', [DailyActivityController::class, 'show']);
        Route::put('/daily-activity/{dailyActivity}', [DailyActivityController::class, 'update']);
        Route::delete('/daily-activity/{dailyActivity}', [DailyActivityController::class, 'destroy']);
        
        // Clients
        Route::get('/clients', [ClientController::class, 'index']);
        Route::get('/clients/{client}', [ClientController::class, 'show']);
    });
}); 