<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class periode_kepengurusan extends Model
{
    use HasFactory;
    protected $fillable = [
        'periode_id',
        'ormawa_id',
        'file_sk',
        'status',
    ];

    public function ormawa(): BelongsTo
    {
        return $this->belongsTo(ormawa::class, 'ormawa_id');
    }
    public function fakultas(): BelongsTo
    {
        return $this->belongsTo(ormawa::class, 'ormawa_id')->with('fakultas')->withDefault();
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(periode::class, 'periode_id');
    }
}
