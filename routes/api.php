<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PasswordController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post("/login", [AuthController::class, "login"]);
Route::post("/forgot-password", [PasswordController::class, "forgotPassword"]);

// Authenticated routes
Route::middleware("auth:sanctum")->group(function () {
    Route::post("/logout", [AuthController::class, "logout"]);
    Route::post("/change-password", [
        PasswordController::class,
        "changePassword",
    ]);

    // Super Admin only
    Route::middleware("role:super_admin")->group(function () {
        Route::apiResource("/admins", AdminController::class)->except(["show"]);
    });
});
