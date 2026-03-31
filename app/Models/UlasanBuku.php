<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model UlasanBuku
 *
 * Mewakili tabel `ulasan_buku` untuk menyimpan ulasan dan rating buku.
 * - `ulasan` berisi komentar/teks ulasan
 * - `rating` (dicasting integer) berisi nilai penilaian buku
 */
class UlasanBuku extends Model
{
    protected $table = 'ulasan_buku';
    protected $fillable = ['user_id', 'buku_id', 'ulasan', 'rating'];

    protected $casts = [
        'rating' => 'integer',
    ];

    /**
     * Relasi: ulasan ini dibuat oleh satu user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi: ulasan ini untuk satu buku.
     */
    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}
