<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model IsiBuku
 *
 * Mewakili tabel `isi_buku` yang menyimpan konten/isi dari sebuah buku.
 * - `id_unik` dipakai sebagai identifier unik untuk mengakses isi buku.
 * - `buku_id` adalah foreign key ke tabel `buku`.
 * - `isi` berisi konten (teks) buku.
 */
class IsiBuku extends Model
{
    protected $table = 'isi_buku';
    protected $fillable = ['id_unik', 'buku_id', 'isi'];

    /**
     * Relasi: isi ini milik satu buku.
     */
    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}
