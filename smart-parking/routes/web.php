<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// ── Public ────────────────────────────────────────────────────────────────────
Route::get('/', [AuthController::class, 'splash'])->name('splash');

Route::get('/daftar',  [AuthController::class, 'showRegister'])->name('register');
Route::post('/daftar', [AuthController::class, 'register'])->name('register.post');

Route::get('/masuk',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/masuk', [AuthController::class, 'login'])->name('login.post');

// ── Protected ─────────────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');
});
