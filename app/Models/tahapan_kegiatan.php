<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class tahapan_kegiatan extends Model
{
    use HasFactory;
    protected $fillable = [
        'kegiatan_id',
        'name',
        'deskripsi',
        'waktu_mulai',
        'waktu_selesai',
        'status',
    ];
    public function kegiatan(): BelongsTo
    {
        return $this->belongsTo(kegiatan::class, 'kegiatan_id');
    }
}
