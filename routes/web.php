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
    // Semua route di bawah ini wajib login (middleware auth).
    // Jika belum login, user akan diarahkan ke halaman autentikasi.

    // Beranda aplikasi: menampilkan daftar buku (halaman utama setelah login).
    Route::get('/', [BukuController::class, 'index']);

    Route::prefix('/kategori-buku')->name('kategori.')->group(function () {
        // Manajemen kategori buku (CRUD) + detail kategori.
        Route::get('/', [KategoriController::class, 'index'])->name('index');
        // Form tambah kategori.
        Route::get('/create', [KategoriController::class, 'create'])->name('create');
        // Simpan kategori baru.
        Route::post('/', [KategoriController::class, 'store'])->name('store');
        // Form edit kategori tertentu.
        Route::get('/{kategori}/edit', [KategoriController::class, 'edit'])->whereNumber('kategori')->name('edit');
        // Update kategori tertentu.
        Route::put('/{kategori}', [KategoriController::class, 'update'])->whereNumber('kategori')->name('update');
        // Hapus kategori tertentu.
        Route::delete('/{kategori}', [KategoriController::class, 'destroy'])->whereNumber('kategori')->name('destroy');
        // Tampilkan detail kategori tertentu.
        Route::get('/{kategori}', [KategoriController::class, 'show'])->whereNumber('kategori')->name('show');
    });

    Route::prefix('/pengguna')->name('user.')->group(function () {
        // Manajemen pengguna (CRUD) untuk admin/operator.
        Route::get('/', [UserController::class, 'index'])->name('index');
        // Form tambah pengguna.
        Route::get('/create', [UserController::class, 'create'])->name('create');
        // Simpan pengguna baru.
        Route::post('/', [UserController::class, 'store'])->name('store');
        // Form edit pengguna tertentu.
        Route::get('/{user}/edit', [UserController::class, 'edit'])->whereNumber('user')->name('edit');
        // Update pengguna tertentu.
        Route::put('/{user}', [UserController::class, 'update'])->whereNumber('user')->name('update');
        // Hapus pengguna tertentu.
        Route::delete('/{user}', [UserController::class, 'destroy'])->whereNumber('user')->name('destroy');
    });

    Route::prefix('/laporan')->name('laporan.')->group(function () {
        // Halaman laporan (rekap) dan ekspor laporan ke PDF.
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        // Export laporan sebagai PDF.
        Route::get('/pdf', [LaporanController::class, 'exportPdf'])->name('pdf');
    });

    Route::prefix('/peminjaman')->name('peminjaman.')->group(function () {
        // Data peminjaman yang sedang/riwayat berjalan.
        Route::get('/', [PinjamanController::class, 'index'])->name('index');
        // Tandai buku sudah dikembalikan (aksi parsial/update status).
        Route::patch('/{peminjaman}/kembalikan', [PinjamanController::class, 'returnBook'])->whereNumber('peminjaman')->name('return');
    });

    Route::prefix('/favorit')->name('favorit.')->group(function () {
        // Daftar buku favorit milik user yang sedang login.
        Route::get('/', [FavoritController::class, 'index'])->name('index');
    });

    Route::prefix('/ulasan-saya')->name('ulasan.')->group(function () {
        // Daftar ulasan yang pernah dibuat oleh user yang sedang login.
        Route::get('/', [UlasanController::class, 'index'])->name('index');
    });

    Route::prefix('/buku')->name('buku.')->group(function () {
        // Manajemen buku (CRUD) + aksi pinjam, favorit, dan ulasan.
        Route::get('/', [BukuController::class, 'index'])->name('index');
        // Menampilkan isi buku tertentu berdasarkan id_unik (route model binding).
        Route::get('/isi/{isiBuku:id_unik}', [PinjamanController::class, 'showIsi'])->whereNumber('isiBuku')->name('isi.show');
        // Form tambah buku.
        Route::get('/create', [BukuController::class, 'create'])->name('create');
        // Simpan buku baru.
        Route::post('/', [BukuController::class, 'store'])->name('store');
        // Aksi meminjam buku tertentu.
        Route::post('/{buku}/pinjam', [PinjamanController::class, 'store'])->whereNumber('buku')->name('pinjam');
        // Tambahkan buku ke favorit.
        Route::post('/{buku}/favorit', [FavoritController::class, 'store'])->whereNumber('buku')->name('favorit.store');
        // Hapus buku dari favorit.
        Route::delete('/{buku}/favorit', [FavoritController::class, 'destroy'])->whereNumber('buku')->name('favorit.destroy');
        // Simpan ulasan untuk buku tertentu.
        Route::post('/{buku}/ulasan', [UlasanController::class, 'store'])->whereNumber('buku')->name('ulasan.store');
        // Form edit buku tertentu.
        Route::get('/{buku}/edit', [BukuController::class, 'edit'])->whereNumber('buku')->name('edit');
        // Update buku tertentu.
        Route::put('/{buku}', [BukuController::class, 'update'])->whereNumber('buku')->name('update');
        // Hapus buku tertentu.
        Route::delete('/{buku}', [BukuController::class, 'destroy'])->whereNumber('buku')->name('destroy');
        // Tampilkan detail buku tertentu.
        Route::get('/{buku}', [BukuController::class, 'show'])->whereNumber('buku')->name('show');
    });
});
