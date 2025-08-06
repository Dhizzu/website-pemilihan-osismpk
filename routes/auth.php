<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
// use App\Http\Controllers\Auth\ConfirmablePasswordController; // Dihapus karena tidak digunakan
// use App\Http\Controllers\Auth\EmailVerificationNotificationController; // Dihapus karena tidak digunakan
// use App\Http\Controllers\Auth\EmailVerificationPromptController; // Dihapus karena tidak digunakan
// use App\Http\Controllers\Auth\NewPasswordController; // Dihapus karena tidak digunakan
// use App\Http\Controllers\Auth\PasswordController; // Dihapus karena tidak digunakan
// use App\Http\Controllers\Auth\PasswordResetLinkController; // Dihapus karena tidak digunakan
// use App\Http\Controllers\Auth\RegisteredUserController; // Dihapus karena tidak digunakan
// use App\Http\Controllers\Auth\VerifyEmailController; // Dihapus karena tidak digunakan
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // Hapus baris ini agar user tidak bisa register
    // Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    // Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    // ... dan route lainnya yang berhubungan dengan guest,
    // pastikan tidak ada route 'register' atau 'password.request' atau 'password.reset'
    // jika Anda tidak ingin fitur reset password.
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    // ... dan route lainnya
});
