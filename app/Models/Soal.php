<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Soal extends Model
{
    use HasFactory;

    protected $fillable = [
        'latihan_id',
        'pertanyaan',
        'tipe_media',
        'url_media',
        'urutan',
    ];

    public function latihan()
    {
        return $this->belongsTo(Latihan::class);
    }

    // Definisikan relasi ke PilihanJawaban
    public function pilihanJawabans()
    {
        return $this->hasMany(PilihanJawaban::class);
    }
}