<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VotingController;
use App\Http\Controllers\StudentImportController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

// Redirect dari halaman utama
Route::get('/', function () {
    if (Auth::check()) {
        return redirect(RouteServiceProvider::HOME);
    }
    return redirect()->route('login');
});

// Grup route yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    // Route untuk voting
    Route::get('/vote', [VotingController::class, 'index'])->name('voting.index');
    Route::post('/vote', [VotingController::class, 'store'])->name('voting.store');
    
    // Route untuk melihat hasil voting
    Route::get('/results', [VotingController::class, 'results'])->name('voting.results');
    
    // Route untuk halaman profil, bisa dihapus jika tidak diperlukan
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    
});

require __DIR__.'/auth.php';