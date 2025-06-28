<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use Illuminate\Http\Request;

class KomentarController extends Controller
{
    /**
     * Simpan komentar baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'materi_id' => 'required|exists:materis,id',
            'body' => 'required|string|max:1000',
        ]);

        Komentar::create([
            'user_id' => auth()->id(), // ✅ fix
            'materi_id' => $validated['materi_id'],
            'body' => $validated['body'],
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }
}
