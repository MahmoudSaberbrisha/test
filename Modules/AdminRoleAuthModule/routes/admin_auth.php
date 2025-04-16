<?php
use Illuminate\Support\Facades\Route;
use Modules\AdminRoleAuthModule\Http\Controllers\Auth\AuthenticatedSessionController;
use Modules\AdminRoleAuthModule\Http\Controllers\Auth\PasswordResetLinkController;
use Modules\AdminRoleAuthModule\Http\Controllers\Auth\NewPasswordController;
use Modules\AdminRoleAuthModule\Http\Controllers\Auth\ConfirmablePasswordController;
use Modules\AdminRoleAuthModule\Http\Controllers\Auth\PasswordController;

Route::namespace('Auth')->middleware('LocaleMiddleware')->group(function () {
    Route::middleware(['guest:admin'])->group(function () {
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [AuthenticatedSessionController::class, 'store']);

        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
        Route::get('email-sent', [PasswordResetLinkController::class, 'emailSent'])->name('email.sent');
        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
        Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');

        Route::group(['middleware' => 'feature:firebase-feature'], function () {
            Route::post('firebase-reset-password', [NewPasswordController::class, 'firebaseResetPassword'])->name('password.firebase-store');
        });
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
        Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    });
});
