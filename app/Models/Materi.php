<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'file_path',
        'modul_id',
        'slug',
        'urutan'
    ];

    /**
     * Relasi Materi -> Komentar
     */
    public function komentars()
    {
        return $this->hasMany(Komentar::class)->latest();
    }

    /**
     * Relasi Materi -> Modul
     */
    public function modul()
    {
        return $this->belongsTo(Modul::class);
    }

    /**
     * Gunakan slug untuk route binding
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Optional: Relasi Materi -> User (jika materi dibuat oleh user tertentu)
     */
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
