<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\TaskController;

// Public Routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Private Routes
Route::middleware(['auth:sanctum'])->group(function(){
    Route::apiResource('tasks', TaskController::class);
    Route::post('/invites/send', [InvitationController::class, 'send']);
    Route::post('/invites/resend', [InvitationController::class, 'resend']);
});