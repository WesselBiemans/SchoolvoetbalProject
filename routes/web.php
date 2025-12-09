<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/tournaments', function () {
    return view('tournaments.index');
})->middleware(['auth', 'verified'])->name('tournaments');
Route::get('/bets', function () {
    return view('bets.index');
})->middleware(['auth', 'verified'])->name('bets');


Route::get('/points', function () {
    return view('points.index');
})->middleware(['auth', 'verified'])->name('points');

require __DIR__ . '/auth.php';
