<?php

use App\Http\Controllers\Auth\OAuthController;
use Illuminate\Support\Facades\Route;

Route::withoutMiddleware('auth:api')->group(function () {
    Route::post('register', [OAuthController::class, 'register']);
    Route::post('login', [OAuthController::class, 'login']);
    Route::post('refresh', [OAuthController::class, 'refreshToken']);

    Route::post('send-verification', [OAuthController::class, 'sendEmailVerification']);
    Route::post('confirm-verification-code', [OAuthController::class, 'confirmAccountVerificationCode']);
    Route::post('verify-account', [OAuthController::class, 'verifyAccount']);

    Route::post('send-forgot-password', [OAuthController::class, 'sendForgotPassword']);
    Route::post('confirm-password-reset-code', [OAuthController::class, 'confirmResetPasswordCode']);
    Route::post('password-reset', [OAuthController::class, 'resetPassword']);
});

Route::get('logout', [OAuthController::class, 'logout']);

// Route::middleware(['verified'])->group(function () { });
