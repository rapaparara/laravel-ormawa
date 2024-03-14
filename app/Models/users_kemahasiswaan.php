<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class users_kemahasiswaan extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'fakultas_id',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function fakultas(): BelongsTo
    {
        return $this->belongsTo(fakultas::class, 'fakultas_id');
    }
    public function kemahasiswaan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id')->with('fakultas')->withDefault();
    }
}
