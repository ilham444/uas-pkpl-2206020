<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Latihan;
use App\Models\Modul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // Import Str untuk pengecekan string

class LatihanController extends Controller
{
    /**
     * Menampilkan daftar semua latihan.
     */
    public function index()
    {
        $latihans = Latihan::with('modul')->withCount('soals')->latest()->paginate(10);
        return view('admin.latihan.index', compact('latihans'));
    }

    /**
     * Menampilkan form untuk membuat latihan baru.
     */
    public function create()
    {
        $moduls = Modul::all();
        
        return view('admin.latihan.create', compact('moduls'));
    }

    /**
     * Menyimpan latihan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'modul_id' => 'required|exists:moduls,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'soal' => 'required|array|min:1',
            'soal.*.pertanyaan' => 'required|string',
            // Validasi file lebih baik dipisah agar pesan error lebih jelas
            'soal.*.media' => 'nullable|file|mimes:mp3,wav,mp4,mov|max:20480', // Max 20MB
            'soal.*.pilihan' => 'required|array|min:2',
            'soal.*.pilihan.*' => 'required|string',
            'soal.*.jawaban_benar' => 'required|numeric',
        ]);

        DB::transaction(function () use ($request) {
            $latihan = Latihan::create([
                'modul_id' => $request->modul_id,
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
            ]);

            foreach ($request->soal as $index => $soalData) {
                // Inisialisasi variabel media
                $urlMediaPath = null;
                $tipeMedia = 'none';

                // Cek dan proses file media jika ada
                if ($request->hasFile("soal.{$index}.media")) {
                    $file = $request->file("soal.{$index}.media");
                    $urlMediaPath = $file->store('media_latihan', 'public');
                    
                    // PERBAIKAN: Pengecekan tipe media yang lebih andal
                    $mimeType = $file->getMimeType();
                    if (Str::startsWith($mimeType, 'video/')) {
                        $tipeMedia = 'video';
                    } elseif (Str::startsWith($mimeType, 'audio/')) {
                        $tipeMedia = 'audio';
                    }
                }

                $soal = $latihan->soals()->create([
                    'pertanyaan' => $soalData['pertanyaan'],
                    'tipe_media' => $tipeMedia,
                    'url_media' => $urlMediaPath,
                    'urutan' => $index + 1,
                ]);

                foreach ($soalData['pilihan'] as $pilihanIndex => $pilihanText) {
                    $soal->pilihanJawabans()->create([
                        'jawaban' => $pilihanText,
                        'is_benar' => ($pilihanIndex == $soalData['jawaban_benar']),
                    ]);
                }
            }
        });

        return redirect()->route('admin.latihan.index')->with('success', 'Latihan berhasil dibuat!');
    }

    /**
     * Menampilkan form untuk mengedit latihan.
     */
    public function edit(Latihan $latihan)
    {
        // Ambil semua modul untuk dropdown
        $moduls = Modul::all();

        // Load relasi soal dan pilihan jawabannya agar bisa di-passing ke form
        $latihan->load('soals.pilihanJawabans');
        
        // Anda perlu membuat view 'admin.latihan.edit'
        return view('admin.latihan.edit', compact('latihan', 'moduls'));
    }

    /**
     * Memperbarui latihan di database.
     */
    public function update(Request $request, Latihan $latihan)
    {
        // Validasi sama seperti store, tapi bisa disesuaikan jika perlu
        $request->validate([
            'modul_id' => 'required|exists:moduls,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'soal' => 'required|array|min:1',
            'soal.*.pertanyaan' => 'required|string',
            'soal.*.media' => 'nullable|file|mimes:mp3,wav,mp4,mov|max:20480',
            'soal.*.pilihan' => 'required|array|min:2',
            'soal.*.pilihan.*' => 'required|string',
            'soal.*.jawaban_benar' => 'required|numeric',
        ]);

        DB::transaction(function () use ($request, $latihan) {
            // 1. Update data utama latihan
            $latihan->update([
                'modul_id' => $request->modul_id,
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
            ]);

            // 2. Hapus semua soal lama agar mudah.
            // (Ini cara paling sederhana untuk menangani update. Alternatifnya lebih kompleks)
            $latihan->soals()->delete(); 

            // 3. Buat ulang semua soal dari data form (logika sama seperti store)
            foreach ($request->soal as $index => $soalData) {
                $urlMediaPath = null;
                $tipeMedia = 'none';

                if ($request->hasFile("soal.{$index}.media")) {
                    $file = $request->file("soal.{$index}.media");
                    $urlMediaPath = $file->store('media_latihan', 'public');
                    
                    $mimeType = $file->getMimeType();
                    if (Str::startsWith($mimeType, 'video/')) {
                        $tipeMedia = 'video';
                    } elseif (Str::startsWith($mimeType, 'audio/')) {
                        $tipeMedia = 'audio';
                    }
                }
                
                // Jika user tidak upload file baru, tapi masih ada file lama
                // Logika ini bisa ditambahkan jika diperlukan, untuk sekarang kita buat simpel.

                $soal = $latihan->soals()->create([
                    'pertanyaan' => $soalData['pertanyaan'],
                    'tipe_media' => $tipeMedia,
                    'url_media' => $urlMediaPath,
                    'urutan' => $index + 1,
                ]);

                foreach ($soalData['pilihan'] as $pilihanIndex => $pilihanText) {
                    $soal->pilihanJawabans()->create([
                        'jawaban' => $pilihanText,
                        'is_benar' => ($pilihanIndex == $soalData['jawaban_benar']),
                    ]);
                }
            }
        });

        return redirect()->route('admin.latihan.index')->with('success', 'Latihan berhasil diperbarui!');
    }

    /**
     * Menghapus latihan dari database.
     */
    public function destroy(Latihan $latihan)
    {
        $latihan->delete();
        return redirect()->route('admin.latihan.index')->with('success', 'Latihan berhasil dihapus.');
    }
}