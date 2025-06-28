<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Latihan;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Kategori::query()->whereHas('moduls');

        // Filter pencarian berdasarkan judul materi
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('moduls', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }

        // Ambil kategori beserta materinya
        $kategoris = $query->with([
            'moduls' => function ($q) use ($request) {
                if ($request->has('search') && $request->search != '') {
                    $q->where('title', 'like', "%{$request->search}%");
                }
            }
        ])->latest()->get();

        // Ambil data latihan terbaru yang memiliki soal
        $latihans = Latihan::withCount('soals')
            ->whereHas('soals')
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact('kategoris', 'latihans'));
    }
}
