<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class kegiatan extends Model
{
    use HasFactory;
    protected $fillable = [
        'ormawa_id',
        'kepengurusan_id',
        'name',
        'deskripsi',
        'waktu_mulai',
        'waktu_selesai',
        'image',
    ];

    public function kepengurusan(): BelongsTo
    {
        return $this->belongsTo(periode_kepengurusan::class, 'kepengurusan_id');
    }
    public function ormawa(): BelongsTo
    {
        return $this->belongsTo(ormawa::class, 'ormawa_id');
    }
}
