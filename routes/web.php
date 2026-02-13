<?php

use App\Http\Controllers\AiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProdukController;
use App\Http\Middleware\Role;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->group(function() {
    // Route::get('/',              [PageController::class, 'home'])->name('home');
    Route::get('/', function(){
        return view('construction');
    });
});

Route::middleware('auth:web')->group(function() {
    Route::post('/logout',        [AuthController::class, 'logout'])->name('logout');
    Route::get('/detail/{id}',    [PageController::class, 'detail'])->name('detail');
    Route::get('/ai',             [PageController::class, 'aiRecommendation'])->name('ai-kikibi');
    Route::get('/hadiah',         [PageController::class, 'etalase'])->name('etalase');
    Route::post('/ai-rekomendasi',[AiController::class, 'cari'])->name('ai-rekomendasi');
});

Route::prefix('/admin')->middleware(['auth:web', Role::class . ':admin'])->group(function() {
    Route::get('/kategori',       [PageController::class, 'kategori'])->name('admin-dashboard');
    Route::resource('/kategori-action', KategoriController::class);

    Route::get('/produk',         [PageController::class, 'produk'])->name('admin-produk');
    Route::resource('/produk-action', ProdukController::class);

    Route::get('/pesanan',         [PageController::class, 'pesanan'])->name('admin-pesanan');
    Route::resource('/pesanan-action', PesananController::class);
});

Route::prefix('/auth')->middleware('guest')->group(function() {
    Route::get('/daftar',       [PageController::class, 'register'])->name('register');
    Route::get('/login',        [PageController::class, 'login'])->name('login');
    Route::post('/verif-login', [AuthController::class, 'login'])->name('Verif-login');
    Route::post('/register',    [AuthController::class, 'register'])->name('Verif-register');
    Route::post('/verify',      [AuthController::class, 'verify'])->name('Verif-verify');
});

