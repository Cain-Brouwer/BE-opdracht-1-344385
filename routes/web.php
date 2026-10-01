<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Categories\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Magazijn\MagazijnController;
use Illuminate\Support\Facades\Route;

// Home page – shows welcome view
Route::view('/', 'home')->name('home');

// Auth routes
Route::middleware('guest')->group(function (): void {
    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->middleware('throttle:5,1');

    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1');
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// Public routes
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

// Protected routes
Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('role:admin')->group(function (): void {
        Route::get('/admin', [DashboardController::class, 'admin'])->name('admin.index');
    });

    // Overzicht Magazijn Jamin – user story 1 en 2
    Route::middleware('role:magazijnmedewerker|admin')->group(function (): void {
        Route::get('/magazijn', [MagazijnController::class, 'index'])->name('magazijn.index');
        Route::get('/magazijn/{product}/leveringsinformatie', [MagazijnController::class, 'leveringsinformatie'])
            ->name('magazijn.leveringsinformatie');
        Route::get('/magazijn/{product}/allergenen', [MagazijnController::class, 'allergenen'])
            ->name('magazijn.allergenen');
    });
});
