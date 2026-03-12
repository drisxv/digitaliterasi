<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IsiBuku extends Model
{
    protected $table = 'isi_buku';
    protected $fillable = ['id_unik', 'buku_id', 'isi'];

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}
