<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Buku extends Model
{
    protected $table = 'buku';
    protected $fillable = ['judul', 'penulis', 'penerbit', 'tahun_terbit', 'kategori_id', 'cover', 'sinopsis'];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function isiBuku(): HasOne
    {
        return $this->hasOne(IsiBuku::class, 'buku_id');
    }

    public function ulasans(): HasMany
    {
        return $this->hasMany(UlasanBuku::class, 'buku_id')->latest();
    }

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'buku_id');
    }

    public function koleksiPribadi(): HasMany
    {
        return $this->hasMany(KoleksiPribadi::class, 'buku_id');
    }
}
