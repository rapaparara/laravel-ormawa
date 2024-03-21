<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class pengurus extends Model
{
    use HasFactory;
    protected $fillable = [
        'nim',
        'nama',
        'kepengurusan_id',
    ];

    public function kepengurusan(): BelongsTo
    {
        return $this->belongsTo(periode_kepengurusan::class, 'kepengurusan_id');
    }
}
