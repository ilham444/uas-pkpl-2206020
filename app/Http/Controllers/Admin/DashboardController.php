<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Modul;
use App\Models\Question;
use App\Models\User;
use App\Models\QuizResult;
use App\Models\Latihan;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin dengan data yang dibutuhkan.
     */
    public function index()
    {
        // =======================
        // 1. DATA STATISTIK KARTU
        // =======================
        $stats = [
            'activeUsers' => [
                'value' => User::where('is_active', true)->count(),
                'change' => '+5.2%',
                'trend' => 'up',
                'chartData' => [30, 40, 35, 50, 49, 60, 70, 91, 125],
            ],
            'views' => [
                'value' => '25.4k',
                'change' => '+12.1%',
                'trend' => 'up',
                'chartData' => [200, 300, 450, 400, 550, 600, 580],
            ],
            'newModules' => [
                'value' => Modul::where('created_at', '>=', now()->subMonth())->count(),
                'change' => '-1.5%',
                'trend' => 'down',
                'chartData' => [10, 8, 12, 9, 11, 7, 6],
            ],
            'sales' => [
                'value' => 'Rp 12,5 jt',
                'change' => 'Stabil',
                'trend' => 'neutral',
                'chartData' => [120, 125, 122, 128, 125, 127],
            ],
        ];

        // =======================
        // 2. PENGGUNA TERBARU
        // =======================
        $recentUsers = User::latest()->take(5)->get();

        foreach ($recentUsers as $user) {
            $user->completed_materi_count = random_int(1, 30); // Dummy, bisa diganti query asli
        }

        // =======================
        // 3. DATA TAMBAHAN
        // =======================
        $questionCount = Question::count();
        $quizSubmissionsCount = QuizResult::count();
        $latihanCount = Latihan::count();

        // =======================
        // 4. RETURN KE VIEW
        // =======================
        return view('admin.dashboard', [
            'stats' => $stats,
            'recentUsers' => $recentUsers,
            'questionCount' => $questionCount,
            'quizSubmissionsCount' => $quizSubmissionsCount,
            'latihanCount' => $latihanCount,
        ]);
    }
}
