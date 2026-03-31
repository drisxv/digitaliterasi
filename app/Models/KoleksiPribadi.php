<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model KoleksiPribadi
 *
 * Mewakili tabel `koleksi_pribadi` yang menyimpan daftar buku favorit/koleksi
 * milik user (pivot sederhana antara user dan buku).
 * - `user_id` pemilik koleksi
 * - `buku_id` buku yang disimpan sebagai favorit/koleksi
 */
class KoleksiPribadi extends Model
{
    protected $table = 'koleksi_pribadi';
    protected $fillable = ['user_id', 'buku_id'];

    /**
     * Relasi: koleksi ini dimiliki oleh satu user.
     */
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi: koleksi ini mengacu ke satu buku.
     */
    public function buku(){
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}
