<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class dokumentasi extends Model
{
    use HasFactory;
    protected $fillable = [
        'tahapan_kegiatan_id',
        'file_dokumentasi',
    ];
    public function tahapan(): BelongsTo
    {
        return $this->belongsTo(tahapan_kegiatan::class, 'tahapan_kegiatan_id');
    }
}
