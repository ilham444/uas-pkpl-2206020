<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Materi;
use App\Models\Modul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MateriController extends Controller
{
    /**
     * Tampilkan daftar semua materi
     */
    public function index(Modul $modul)
    {
        $materi = $modul->materis()->latest()->paginate(10);
        return view('admin.materi.index', compact('materi', 'modul'));
    }

    /**
     * Tampilkan form untuk menambahkan materi baru
     */
    public function create(Modul $modul)
    {
        $moduls = Modul::all(); // <-- Ambil semua modul
        return view('admin.materi.create', compact('moduls', 'modul'));
    }

    /**
     * Simpan materi baru ke database
     */
    public function store(Request $request, Modul $modul)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'required|file|mimes:pdf,jpg,png,mp4,webm,ogg|max:51200',
            'urutan' => 'required|integer'
        ]);

        // Simpan file
        $filePath = $request->file('file')->store('materi_files', 'public');

        // Buat slug unik
        $slug = $this->generateUniqueSlug($request->title);

        // Simpan ke database
        Materi::create([
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'file_path' => $filePath,
            'modul_id' => $modul->id,
            'urutan' => $request->urutan
        ]);

        return redirect()->route('admin.modul.materi.index', $modul)->with('success', 'Materi berhasil ditambahkan.');
    }

    /**
     * Tampilkan form untuk edit materi
     */
    public function edit(Modul $modul, Materi $materi)
    {
        $kategoris = Kategori::all(); // <-- Ambil semua kategori
        return view('admin.materi.edit', compact('materi', 'kategoris', 'modul')); // <-- Kirim ke view
    }

    /**
     * Update data materi yang sudah ada
     */
    public function update(Request $request, Modul $modul, Materi $materi)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,jpg,png,mp4|max:10240',
            'urutan' => 'required|integer'
        ]);

        $filePath = $materi->file_path;

        // Ganti file jika ada file baru diupload
        if ($request->hasFile('file')) {
            if (Storage::disk('public')->exists($materi->file_path)) {
                Storage::disk('public')->delete($materi->file_path);
            }

            $filePath = $request->file('file')->store('materi_files', 'public');
        }

        // Perbarui slug hanya jika judul berubah
        $slug = $materi->slug;
        if ($materi->title !== $request->title) {
            $slug = $this->generateUniqueSlug($request->title, $materi->id);
        }

        $materi->update([
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'file_path' => $filePath,
            'urutan' => $request->urutan
        ]);

        return redirect()->route('admin.modul.materi.index', $modul)->with('success', 'Materi berhasil diperbarui.');
    }

    /**
     * Hapus materi dari database dan storage
     */
    public function destroy(Modul $modul, Materi $materi)
    {
        $materi->delete();

        return redirect()->route('admin.modul.materi.index', $modul)->with('success', 'Materi berhasil dihapus.');
    }

    /**
     * Generate slug unik dari title
     */
    protected function generateUniqueSlug(string $title, $ignoreId = null)
    {
        $slug = Str::slug($title);
        $original = $slug;
        $counter = 1;

        while (Materi::where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $original . '-' . $counter++;
        }

        return $slug;
    }
}
