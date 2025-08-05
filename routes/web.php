<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\VotingController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [VotingController::class, 'dashboard'])->name('dashboard');
    Route::get('/vote-selection', [VotingController::class, 'selectionPage'])->name('vote.selection');
    Route::get('/vote-osis', [VotingController::class, 'showOsisCandidates'])->name('vote.osis');
    Route::get('/vote-mpk', [VotingController::class, 'showMpkCandidates'])->name('vote.mpk');
    Route::post('/vote', [VotingController::class, 'processVote'])->name('vote.process');

    Route::get('/import-users', [ImportController::class, 'showImportForm'])->name('users.import.form');
    Route::post('/import-users', [ImportController::class, 'importUsers'])->name('users.import');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
