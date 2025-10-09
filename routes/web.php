<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReturnController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Book browsing routes for members
    Route::get('/books/browse', [DashboardController::class, 'browse'])->name('books.browse');
    Route::get('/books/search', [DashboardController::class, 'search'])->name('books.search');
    Route::get('/books/{id}', [DashboardController::class, 'show'])->name('books.show');
});

// Return Routes - untuk pustakawan dan admin
Route::middleware(['auth'])->group(function () {
    Route::get('/returns', [ReturnController::class, 'index'])->name('returns.index');
    Route::get('/returns/search', [ReturnController::class, 'search'])->name('returns.search');
    Route::get('/returns/{id}', [ReturnController::class, 'show'])->name('returns.show');
    Route::post('/returns/{id}/process', [ReturnController::class, 'process'])->name('returns.process');
    Route::get('/returns-history', [ReturnController::class, 'history'])->name('returns.history');
});
