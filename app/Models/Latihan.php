<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Latihan extends Model
{
    use HasFactory;

    protected $guarded = ['id']; // Memudahkan saat create/update

    public function modul(): BelongsTo
    {
        return $this->belongsTo(Modul::class);
    }

    public function soals(): HasMany
    {
        return $this->hasMany(Soal::class)->orderBy('urutan');
    }
}