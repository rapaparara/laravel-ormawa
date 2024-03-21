<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class users_ormawa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ormawa_id',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function ormawa(): BelongsTo
    {
        return $this->belongsTo(ormawa::class, 'ormawa_id');
    }
    public function penggunaOrmawa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id')->with('ormawa')->withDefault();
    }
}
