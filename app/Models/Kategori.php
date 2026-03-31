<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model Kategori
 *
 * Mewakili tabel `kategori` untuk mengelompokkan buku berdasarkan kategori.
 * - `nama_kategori` menyimpan nama kategori.
 */
class Kategori extends Model
{
    protected $table = 'kategori';
    protected $fillable = ['nama_kategori'];

    /**
     * Relasi: satu kategori memiliki banyak buku.
     */
    public function bukus(): HasMany
    {
        return $this->hasMany(Buku::class, 'kategori_id');
    }
}
