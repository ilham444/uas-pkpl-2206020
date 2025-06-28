<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Modul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ModulController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    // Awal query modul
    $query = Modul::query();

    // Filter berdasarkan pencarian judul jika ada
    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    // Filter berdasarkan kategori jika dipilih
    if ($request->filled('kategori')) {
        $query->where('kategori_id', $request->kategori);
    }

    // Ambil data modul terurut dari yang terbaru dan paginasi
    $moduls = $query->latest()->paginate(10)->appends($request->query());

    // Ambil semua kategori untuk keperluan dropdown filter
    $kategoris = Kategori::all();

    // Kirim data ke view
    return view('admin.modul.index', compact('moduls', 'kategoris'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.modul.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // [UPDATED] Validasi disesuaikan dengan form baru.
        // 'thumbnail' sekarang wajib dan menerima berbagai jenis file.
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:moduls,title',
            'kategori_id' => 'required|exists:kategoris,id',
            'description' => 'required|string',
            'estimated' => 'required|integer|min:1',
            'thumbnail' => 'required|file|mimes:png,jpg,jpeg,webp,pdf,doc,docx,mp4,webm|max:10240', // Maks 10MB
        ]);

        // Generate slug unik saat pembuatan. Menambahkan timestamp untuk menghindari duplikasi.
        $validated['slug'] = 'modul-' . Str::slug($request->title) . '-' . time();

        // [UPDATED] Nama folder diubah menjadi 'modul-content' agar lebih deskriptif.
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('modul-content', 'public');
        }

        Modul::create($validated);
        
        return redirect()->route('admin.modul.index')->with('success', 'Modul baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Modul $modul)
    {
        return view('admin.modul.show', compact('modul'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Modul $modul)
    {
        $kategoris = Kategori::all();
        return view('admin.modul.edit', compact('modul', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Modul $modul)
    {
        // [UPDATED] Validasi disesuaikan. 'thumbnail' sekarang nullable agar tidak wajib di-upload ulang.
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:moduls,title,' . $modul->id,
            'kategori_id' => 'required|exists:kategoris,id',
            'description' => 'required|string',
            'estimated' => 'required|integer|min:1',
            'thumbnail' => 'nullable|file|mimes:png,jpg,jpeg,webp,pdf,doc,docx,mp4,webm|max:10240', // Maks 10MB
        ]);

        // [IMPROVED] Slug hanya di-update jika judul berubah. Ini menjaga URL tetap stabil.
        if ($request->title !== $modul->title) {
            $validated['slug'] = 'modul-' . Str::slug($request->title) . '-' . time();
        }

        if ($request->hasFile('thumbnail')) {
            // Hapus file lama jika ada
            if ($modul->thumbnail && Storage::disk('public')->exists($modul->thumbnail)) {
                Storage::disk('public')->delete($modul->thumbnail);
            }
            // Simpan file baru dengan path yang konsisten
            $validated['thumbnail'] = $request->file('thumbnail')->store('modul-content', 'public');
        }

        $modul->update($validated);
        
        return redirect()->route('admin.modul.index')->with('success', 'Modul berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Modul $modul)
    {
        // Hapus file konten yang terhubung dengan modul
        if ($modul->thumbnail && Storage::disk('public')->exists($modul->thumbnail)) {
            Storage::disk('public')->delete($modul->thumbnail);
        }

        $modul->delete();
        
        return redirect()->route('admin.modul.index')->with('success', 'Modul berhasil dihapus.');
    }
}