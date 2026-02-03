<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->group(function() {
    Route::get('/', [PageController::class, 'home'])->name('home');
    Route::get('/ai', [PageController::class, 'aiRecommendation'])->name('ai-kikibi');
    Route::get('/etalase', [PageController::class, 'etalase'])->name('etalase');
});
