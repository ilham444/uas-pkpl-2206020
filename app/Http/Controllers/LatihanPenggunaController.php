<?php

namespace App\Http\Controllers;

use App\Models\Latihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Jika perlu info user

class LatihanPenggunaController extends Controller
{
    /**
     * Menampilkan halaman pengerjaan latihan untuk pengguna.
     *
     * @param  \App\Models\Latihan  $latihan
     * @return \Illuminate\View\View
     */
    public function show(Latihan $latihan)
    {
        // Load relasi soal dan pilihan jawabannya
        // Kita acak urutan soal dan pilihan jawaban agar lebih dinamis
        $latihan->load(['soals' => function ($query) {
            $query->inRandomOrder();
        }, 'soals.pilihanJawabans' => function ($query) {
            $query->inRandomOrder();
        }]);

        // Kirim data ke view
        return view('latihan.show', compact('latihan'));
    }

    /**
     * Memproses jawaban dari pengguna dan menampilkan hasil.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Latihan  $latihan
     * @return \Illuminate\View\View
     */
    public function submit(Request $request, Latihan $latihan)
    {
        // Validasi input jawaban dari pengguna
        $request->validate([
            'jawaban' => 'required|array',
            'jawaban.*' => 'required|numeric', // Memastikan setiap jawaban adalah ID pilihan
        ]);

        $jawabanPengguna = $request->input('jawaban'); // format: [soal_id => pilihan_id, ...]
        
        $skor = 0;
        $totalSoal = $latihan->soals->count();
        $hasilJawaban = [];

        // Load semua soal dengan pilihan jawaban yang benar
        $semuaSoal = $latihan->soals()->with('pilihanJawabans')->get();

        foreach ($semuaSoal as $soal) {
            $jawabanBenarId = $soal->pilihanJawabans->where('is_benar', true)->first()->id;
            $jawabanPenggunaId = $jawabanPengguna[$soal->id] ?? null;

            $isBenar = ($jawabanBenarId == $jawabanPenggunaId);

            if ($isBenar) {
                $skor++;
            }

            // Simpan detail untuk ditampilkan di halaman hasil
            $hasilJawaban[] = [
                'soal' => $soal,
                'jawaban_pengguna_id' => $jawabanPenggunaId,
                'is_benar' => $isBenar,
            ];
        }

        // Hitung nilai akhir (misal: dari 0-100)
        $nilaiAkhir = ($totalSoal > 0) ? ($skor / $totalSoal) * 100 : 0;
        
        // Simpan hasil ke database jika Anda punya tabel 'hasil_latihan'
        // HasilLatihan::create([
        //     'user_id' => Auth::id(),
        //     'latihan_id' => $latihan->id,
        //     'skor' => $skor,
        //     'nilai' => $nilaiAkhir,
        // ]);

        // Tampilkan halaman hasil
        return view('latihan.hasil', [
            'latihan' => $latihan,
            'skor' => $skor,
            'totalSoal' => $totalSoal,
            'nilaiAkhir' => round($nilaiAkhir),
            'hasilJawaban' => $hasilJawaban,
        ]);
    }
}