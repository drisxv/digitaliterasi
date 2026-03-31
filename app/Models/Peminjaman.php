<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model Peminjaman
 *
 * Mewakili tabel `peminjaman` untuk transaksi peminjaman buku oleh user.
 * Field penting:
 * - `tanggal_peminjaman` dan `tanggal_pengembalian` (dicasting ke date)
 * - `status_peminjaman` untuk status (mis. dipinjam/dikembalikan)
 */
class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $fillable = ['user_id', 'buku_id', 'tanggal_peminjaman', 'tanggal_pengembalian', 'status_peminjaman'];

    protected $casts = [
        'tanggal_peminjaman' => 'date',
        'tanggal_pengembalian' => 'date',
    ];

    /**
     * Relasi: peminjaman ini dilakukan oleh satu user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi: peminjaman ini untuk satu buku.
     */
    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}
