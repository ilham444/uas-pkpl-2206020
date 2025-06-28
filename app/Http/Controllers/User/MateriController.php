<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\Modul;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    /**
     * Tampilkan detail materi untuk user, termasuk komentar-komentar dan user yang mengomentari.
     */
    public function show(Modul $modul, Materi $materi)
    {
        // Memuat relasi komentar beserta user-nya
        $materi->load(['komentars.user']);

        // Cari materi selanjutnya berdasarkan urutan dan waktu dibuat
        $nextMateri = $modul->materis()
            ->where(function ($query) use ($materi) {
                $query->where('urutan', '>', $materi->urutan)
                    ->orWhere(function ($q) use ($materi) {
                        $q->where('urutan', $materi->urutan)
                            ->where('created_at', '>', $materi->created_at);
                    });
            })
            ->orderBy('urutan')
            ->orderBy('created_at')
            ->first();


        return view('user.materi.show', compact('materi', 'modul', 'nextMateri'));
    }
}
