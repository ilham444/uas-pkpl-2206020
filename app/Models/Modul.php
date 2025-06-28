<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modul extends Model
{
    protected $fillable = [
        'title',
        'kategori_id',
        'slug',
        'description',
        'estimated',
        'thumbnail'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function materis()
    {
        return $this->hasMany(Materi::class);
    }
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
    public function latihans() {
    return $this->hasMany(Latihan::class);
}
    
}
