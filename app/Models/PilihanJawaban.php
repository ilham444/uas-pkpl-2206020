<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PilihanJawaban extends Model
{
    use HasFactory;

    protected $fillable = [
        'soal_id',
        'jawaban',
        'is_benar',
    ];

    public function soal()
    {
        return $this->belongsTo(Soal::class);
    }
}