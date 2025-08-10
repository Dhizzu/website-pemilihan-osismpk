<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminCandidateController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VotingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentImportController;
use App\Http\Controllers\Auth\AdminLoginController;

// Redirect dari halaman utama
Route::get('/', function () {
    if (Auth::guard('admin')->check()) {
        return redirect()->route('admin.dashboard');
    }
    if (Auth::check()) {
        return redirect(RouteServiceProvider::HOME);
    }
    return redirect()->route('login');
});

// Admin login routes
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// Grup route yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    // Route untuk voting
    Route::get('/vote', [VotingController::class, 'index'])->name('voting.index');
    Route::post('/vote', [VotingController::class, 'store'])->name('voting.store');

    // Route untuk halaman profil, bisa dihapus jika tidak diperlukan
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes - using new admin guard with rate limiting
Route::middleware(['auth:admin', 'throttle:60,1'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/results', [AdminController::class, 'results'])->name('results');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/generate-token', [AdminUserController::class, 'generateToken'])->name('users.generate-token');
    Route::post('/users/generate-tokens-all', [AdminUserController::class, 'generateTokensForAll'])->name('users.generate-tokens-all');
    
    // Candidate management routes
    Route::get('/candidates', [AdminCandidateController::class, 'index'])->name('candidates.index');
    Route::get('/candidates/create', [AdminCandidateController::class, 'create'])->name('candidates.create');
    Route::post('/candidates', [AdminCandidateController::class, 'store'])->name('candidates.store');
    Route::get('/candidates/{candidate}/edit', [AdminCandidateController::class, 'edit'])->name('candidates.edit');
    Route::put('/candidates/{candidate}', [AdminCandidateController::class, 'update'])->name('candidates.update');
    Route::delete('/candidates/{candidate}', [AdminCandidateController::class, 'destroy'])->name('candidates.destroy');
});

require __DIR__.'/auth.php';
