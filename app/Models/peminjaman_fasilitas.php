<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class peminjaman_fasilitas extends Model
{
    use HasFactory;
    protected $fillable = [
        'fasilitas_id',
        'ormawa_id',
        'waktu_mulai',
        'waktu_selesai',
        'file_surat',
        'status',
    ];
    public function fasilitas(): BelongsTo
    {
        return $this->belongsTo(fasilitas::class, 'fasilitas_id');
    }
    public function ormawa(): BelongsTo
    {
        return $this->belongsTo(ormawa::class, 'ormawa_id');
    }
}
