<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug'];

    // Satu kategori memiliki banyak materi
    public function moduls()
    {
        return $this->hasMany(Modul::class);
    }
}
