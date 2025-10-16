<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('landing');
})->name('welcome');

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
    Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');
    
    // Add yours - Member can add their own books
    Route::get('/add-yours', [BookController::class, 'addYoursForm'])->name('books.add-yours');
    Route::post('/add-yours', [BookController::class, 'storeUserBook'])->name('books.store-user-book');
    
    // User return routes
    Route::get('/my-returns', [ReturnController::class, 'userReturns'])->name('user.returns');
    
    // Loan Management API Routes
    Route::prefix('api')->group(function () {
        Route::post('/request-loan', [LoanController::class, 'requestLoan'])->name('api.request-loan');
        Route::get('/borrowed-books', [LoanController::class, 'getBorrowedBooks'])->name('api.borrowed-books');
        Route::get('/loan-history', [LoanController::class, 'getLoanHistory'])->name('api.loan-history');
        Route::post('/extend-loan/{id}', [LoanController::class, 'extendLoan'])->name('api.extend-loan');
        Route::get('/books/{id}', [DashboardController::class, 'getBookDetails'])->name('api.book-details');
        
        // Book interactions (rating, comments, wishlist)
        Route::post('/books/{id}/rate', [BookController::class, 'rateBook'])->name('api.book.rate');
        Route::post('/books/{id}/wishlist', [BookController::class, 'toggleWishlist'])->name('api.book.wishlist');
        Route::post('/books/{id}/comments', [BookController::class, 'addComment'])->name('api.book.comment');
        Route::get('/wishlist', [BookController::class, 'getWishlist'])->name('api.wishlist');
        
        // Return request API
        Route::post('/returns/submit', [ReturnController::class, 'submitReturn'])->name('api.returns.submit');
        Route::post('/returns/clear', [ReturnController::class, 'clearReturnRequest'])->name('api.returns.clear');
        
        // Admin routes for loan management
        Route::middleware(['role:admin,pustakawan'])->group(function () {
            Route::get('/pending-requests', [LoanController::class, 'getPendingRequests'])->name('api.pending-requests');
            Route::post('/approve-loan/{id}', [LoanController::class, 'approveLoan'])->name('api.approve-loan');
            Route::post('/reject-loan/{id}', [LoanController::class, 'rejectLoan'])->name('api.reject-loan');
            Route::get('/admin/loan-requests', [LoanController::class, 'getAllLoanRequests'])->name('api.admin.loan-requests');
            Route::post('/admin/loans/{id}/approve', [LoanController::class, 'approveLoan'])->name('api.admin.loans.approve');
            Route::post('/admin/loans/{id}/reject', [LoanController::class, 'rejectLoan'])->name('api.admin.loans.reject');
        });
    });
    
    // Admin pages for loan management
    Route::middleware(['role:admin,pustakawan'])->group(function () {
        Route::get('/loan-requests', [LoanController::class, 'showLoanRequests'])->name('loan-requests');
        Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports');
        Route::get('/reports/download', [ReportController::class, 'download'])->name('admin.reports.download');
        Route::get('/reports/download-excel', [ReportController::class, 'downloadExcel'])->name('admin.reports.download.excel');
    });
    
    // Admin Returns Routes - Khusus untuk Admin (BUKAN pustakawan biasa)
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/returns', [ReturnController::class, 'adminIndex'])->name('admin.returns.index');
        Route::get('/returns/search', [ReturnController::class, 'adminSearch'])->name('admin.returns.search');
        Route::post('/returns/{id}/process', [ReturnController::class, 'adminProcess'])->name('admin.returns.process');
        
        // Books Management Routes
        Route::get('/books', [BookController::class, 'index'])->name('admin.books.index');
        Route::post('/books', [BookController::class, 'store'])->name('admin.books.store');
        Route::get('/books/{id}/edit', [BookController::class, 'edit'])->name('admin.books.edit');
        Route::post('/books/{id}', [BookController::class, 'update'])->name('admin.books.update');
        Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('admin.books.destroy');
        
        // Users Management Routes (Kelola Anggota)
        Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::post('/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
        Route::post('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');
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
