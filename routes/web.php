<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\LoanController;

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
    
    // Loan Management API Routes
    Route::prefix('api')->group(function () {
        Route::post('/request-loan', [LoanController::class, 'requestLoan'])->name('api.request-loan');
        Route::get('/borrowed-books', [LoanController::class, 'getBorrowedBooks'])->name('api.borrowed-books');
        Route::get('/loan-history', [LoanController::class, 'getLoanHistory'])->name('api.loan-history');
        Route::post('/extend-loan/{id}', [LoanController::class, 'extendLoan'])->name('api.extend-loan');
        Route::get('/books/{id}', [DashboardController::class, 'getBookDetails'])->name('api.book-details');
        
        // Admin routes for loan management
        Route::middleware(['role:admin,pustakawan'])->group(function () {
            Route::get('/pending-requests', [LoanController::class, 'getPendingRequests'])->name('api.pending-requests');
            Route::post('/approve-loan/{id}', [LoanController::class, 'approveLoan'])->name('api.approve-loan');
            Route::post('/reject-loan/{id}', [LoanController::class, 'rejectLoan'])->name('api.reject-loan');
        });
    });
});

// Return Routes - untuk pustakawan dan admin
Route::middleware(['auth'])->group(function () {
    Route::get('/returns', [ReturnController::class, 'index'])->name('returns.index');
    Route::get('/returns/search', [ReturnController::class, 'search'])->name('returns.search');
    Route::get('/returns/{id}', [ReturnController::class, 'show'])->name('returns.show');
    Route::post('/returns/{id}/process', [ReturnController::class, 'process'])->name('returns.process');
    Route::get('/returns-history', [ReturnController::class, 'history'])->name('returns.history');
});
