<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class ormawa extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
        'fakultas_id',
    ];
    public function fakultas(): BelongsTo
    {
        return $this->belongsTo(fakultas::class, 'fakultas_id');
    }
    
    public function periodes(): HasManyThrough
    {
        return $this->hasManyThrough(Periode::class, periode_kepengurusan::class);
    }

    public function periodeKepengurusan(): HasMany
    {
        return $this->hasMany(periode_kepengurusan::class);
    }
}
