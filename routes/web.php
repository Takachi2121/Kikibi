<?php

use App\Http\Controllers\AiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->group(function() {
    Route::get('/',              [PageController::class, 'home'])->name('home');
});

Route::middleware('auth:web')->group(function() {
    Route::post('/logout',       [AuthController::class, 'logout'])->name('logout');
    Route::get('/detail/{id}',   [PageController::class, 'detail'])->name('detail');
    Route::get('/ai',            [PageController::class, 'aiRecommendation'])->name('ai-kikibi');
    Route::get('/hadiah',        [PageController::class, 'etalase'])->name('etalase');
    Route::post('/ai-rekomendasi',[AiController::class, 'cari'])->name('ai-rekomendasi');
});

Route::prefix('/auth')->middleware('guest')->group(function() {
    Route::get('/daftar',       [PageController::class, 'register'])->name('register');
    Route::get('/login',        [PageController::class, 'login'])->name('login');
    Route::post('/verif-login', [AuthController::class, 'login'])->name('Verif-login');
    Route::post('/register',    [AuthController::class, 'register'])->name('Verif-register');
    Route::post('/verify',      [AuthController::class, 'verify'])->name('Verif-verify');
});

