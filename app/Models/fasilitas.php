<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class fasilitas extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'fakultas_id',
    ];
    public function fakultas(): BelongsTo
    {
        return $this->belongsTo(fakultas::class, 'fakultas_id');
    }
}
