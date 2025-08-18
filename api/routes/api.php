<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminController;

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

// Authentication routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot', [AuthController::class, 'forgotPassword']);
    Route::post('/reset', [AuthController::class, 'resetPassword']);
    Route::post('/verify', [AuthController::class, 'verifyEmail']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
        Route::put('/me', [AuthController::class, 'updateProfile']);
    });
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Payment routes
    Route::prefix('payments')->group(function () {
        Route::get('/config', [PaymentController::class, 'getConfig']);
        Route::post('/initialize', [PaymentController::class, 'initializeSubscription']);
        Route::post('/verify', [PaymentController::class, 'verifyPayment']);
        Route::post('/cancel', [PaymentController::class, 'cancelSubscription']);
        Route::post('/upgrade', [PaymentController::class, 'upgradeSubscription']);
        Route::get('/history', [PaymentController::class, 'getPaymentHistory']);
    });

    // Admin routes
    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard']);
        Route::get('/members', [AdminController::class, 'members']);
        Route::post('/members', [AdminController::class, 'createMember']);
        Route::put('/members/{user}', [AdminController::class, 'updateMember']);
        Route::put('/members/{user}/suspend', [AdminController::class, 'suspendMember']);
        Route::delete('/members/{user}', [AdminController::class, 'deleteMember']);
        Route::get('/payments', [AdminController::class, 'payments']);
        Route::get('/subscriptions', [AdminController::class, 'subscriptions']);
        Route::get('/reports', [AdminController::class, 'reports']);
        Route::get('/audit-logs', [AdminController::class, 'auditLogs']);
        Route::get('/announcements', [AdminController::class, 'announcements']);
        Route::post('/announcements', [AdminController::class, 'createAnnouncement']);
        Route::put('/announcements/{announcement}', [AdminController::class, 'updateAnnouncement']);
        Route::delete('/announcements/{announcement}', [AdminController::class, 'deleteAnnouncement']);
        Route::get('/events', [AdminController::class, 'events']);
        Route::post('/events', [AdminController::class, 'createEvent']);
        Route::put('/events/{event}', [AdminController::class, 'updateEvent']);
        Route::delete('/events/{event}', [AdminController::class, 'deleteEvent']);
        Route::get('/resources', [AdminController::class, 'resources']);
        Route::post('/resources', [AdminController::class, 'createResource']);
        Route::put('/resources/{resource}', [AdminController::class, 'updateResource']);
        Route::delete('/resources/{resource}', [AdminController::class, 'deleteResource']);
    });
});

// Webhook routes (no auth required)
Route::post('/webhooks/flutterwave', [PaymentController::class, 'handleWebhook']);
