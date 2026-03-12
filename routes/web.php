<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\FavoritController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [BukuController::class, 'index']);

    Route::prefix('/kategori-buku')->name('kategori.')->group(function () {
        Route::get('/', [KategoriController::class, 'index'])->name('index');
        Route::get('/create', [KategoriController::class, 'create'])->name('create');
        Route::post('/', [KategoriController::class, 'store'])->name('store');
        Route::get('/{kategori}/edit', [KategoriController::class, 'edit'])->whereNumber('kategori')->name('edit');
        Route::put('/{kategori}', [KategoriController::class, 'update'])->whereNumber('kategori')->name('update');
        Route::delete('/{kategori}', [KategoriController::class, 'destroy'])->whereNumber('kategori')->name('destroy');
        Route::get('/{kategori}', [KategoriController::class, 'show'])->whereNumber('kategori')->name('show');
    });

    Route::prefix('/pengguna')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->whereNumber('user')->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->whereNumber('user')->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->whereNumber('user')->name('destroy');
    });

    Route::prefix('/laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/pdf', [LaporanController::class, 'exportPdf'])->name('pdf');
    });

    Route::prefix('/peminjaman')->name('peminjaman.')->group(function () {
        Route::get('/', [PinjamanController::class, 'index'])->name('index');
        Route::patch('/{peminjaman}/kembalikan', [PinjamanController::class, 'returnBook'])->whereNumber('peminjaman')->name('return');
    });

    Route::prefix('/favorit')->name('favorit.')->group(function () {
        Route::get('/', [FavoritController::class, 'index'])->name('index');
    });

    Route::prefix('/ulasan-saya')->name('ulasan.')->group(function () {
        Route::get('/', [UlasanController::class, 'index'])->name('index');
    });

    Route::prefix('/buku')->name('buku.')->group(function () {
        Route::get('/', [BukuController::class, 'index'])->name('index');
        Route::get('/isi/{isiBuku:id_unik}', [PinjamanController::class, 'showIsi'])->whereNumber('isiBuku')->name('isi.show');
        Route::get('/create', [BukuController::class, 'create'])->name('create');
        Route::post('/', [BukuController::class, 'store'])->name('store');
        Route::post('/{buku}/pinjam', [PinjamanController::class, 'store'])->whereNumber('buku')->name('pinjam');
        Route::post('/{buku}/favorit', [FavoritController::class, 'store'])->whereNumber('buku')->name('favorit.store');
        Route::delete('/{buku}/favorit', [FavoritController::class, 'destroy'])->whereNumber('buku')->name('favorit.destroy');
        Route::post('/{buku}/ulasan', [UlasanController::class, 'store'])->whereNumber('buku')->name('ulasan.store');
        Route::get('/{buku}/edit', [BukuController::class, 'edit'])->whereNumber('buku')->name('edit');
        Route::put('/{buku}', [BukuController::class, 'update'])->whereNumber('buku')->name('update');
        Route::delete('/{buku}', [BukuController::class, 'destroy'])->whereNumber('buku')->name('destroy');
        Route::get('/{buku}', [BukuController::class, 'show'])->whereNumber('buku')->name('show');
    });
});
