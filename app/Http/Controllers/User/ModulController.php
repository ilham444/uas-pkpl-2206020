<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Modul;
use Illuminate\Http\Request;

class ModulController extends Controller
{
    /**
     * Tampilkan detail materi untuk user, termasuk komentar-komentar dan user yang mengomentari.
     */
    public function show(Modul $modul)
    {
        // Memuat relasi komentar beserta user-nya
        $modul->load([
            'materis' => function ($query) {
                $query->orderBy('urutan')->orderBy('created_at');
            }
        ]);

        return view('user.modul.show', compact('modul'));
    }
}
