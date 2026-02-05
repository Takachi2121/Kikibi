<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->group(function() {
    Route::get('/', [PageController::class, 'home'])->name('home');
    Route::get('/ai', [PageController::class, 'aiRecommendation'])->name('ai-kikibi');
    Route::get('/hadiah', [PageController::class, 'etalase'])->name('etalase');
    Route::get('/detail', [PageController::class, 'detail'])->name('detail');
    Route::get('/login', [PageController::class, 'login'])->name('login');
    Route::get('/daftar', [PageController::class, 'register'])->name('register');
});
