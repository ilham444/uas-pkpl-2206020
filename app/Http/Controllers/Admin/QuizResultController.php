<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuizResult; // Import model
use Illuminate\Http\Request;

class QuizResultController extends Controller
{
    public function index()
    {
        // Ambil semua hasil, urutkan dari yang terbaru
        // Gunakan 'with('user')' untuk Eager Loading, ini lebih efisien
        $results = QuizResult::with('user')->latest()->paginate(15);
        
        return view('admin.quiz_results.index', compact('results'));
    }
}