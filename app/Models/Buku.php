<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Model Buku
 *
 * Mewakili tabel `buku` yang menyimpan metadata buku.
 * Field penting:
 * - `judul`, `penulis`, `penerbit`, `tahun_terbit`
 * - `kategori_id` untuk pengelompokan kategori
 * - `cover` untuk path/nama file cover
 * - `sinopsis` ringkasan buku
 */
class Buku extends Model
{
    protected $table = 'buku';
    protected $fillable = ['judul', 'penulis', 'penerbit', 'tahun_terbit', 'kategori_id', 'cover', 'sinopsis'];

    /**
     * Relasi: buku ini termasuk ke satu kategori.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    /**
     * Relasi: buku memiliki satu record isi buku (konten).
     */
    public function isiBuku(): HasOne
    {
        return $this->hasOne(IsiBuku::class, 'buku_id');
    }

    /**
     * Relasi: daftar ulasan untuk buku ini (diurutkan terbaru).
     */
    public function ulasans(): HasMany
    {
        return $this->hasMany(UlasanBuku::class, 'buku_id')->latest();
    }

    /**
     * Relasi: riwayat peminjaman untuk buku ini.
     */
    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'buku_id');
    }

    /**
     * Relasi: buku yang difavoritkan/masuk koleksi pribadi oleh banyak user.
     */
    public function koleksiPribadi(): HasMany
    {
        return $this->hasMany(KoleksiPribadi::class, 'buku_id');
    }
}
