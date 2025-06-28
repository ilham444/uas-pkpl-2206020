<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question; // Import model
use App\Models\QuizResult; // <-- 1. IMPORT MODEL BARU
use Illuminate\Support\Facades\Auth; 


class QuizController extends Controller
{
    // Menampilkan halaman quiz
    public function start()
    {
        // Ambil semua soal, acak urutannya
        $questions = Question::inRandomOrder()->get();
        return view('quiz.start', compact('questions'));
        $questions = Question::inRandomOrder()->get();
        if ($questions->isEmpty()) {
            return redirect()->route('dashboard')->with('error', 'Maaf, quiz belum tersedia.');
        }
        return view('quiz.start', compact('questions'));
    }

    // Memproses jawaban quiz
    public function submit(Request $request)
    {
        $answers = $request->input('answers');
        $questions = Question::find(array_keys($answers));
        
        $score = 0;
        $totalQuestions = $questions->count();

        foreach ($questions as $question) {
            // Cek jika jawaban user sama dengan jawaban yang benar
            if (isset($answers[$question->id]) && $answers[$question->id] === $question->correct_answer) {
                $score++;
            }
        }
        $request->validate(['answers' => 'required|array']);
        $answers = $request->input('answers');
        $questionIds = array_keys($answers);
        $questions = Question::find($questionIds);

        $score = 0;
        foreach ($questions as $question) {
            if (isset($answers[$question->id]) && $answers[$question->id] === $question->correct_answer) {
                $score++;
            }
        }
        // Simpan hasil ke session untuk ditampilkan di halaman hasil
        session()->flash('quiz_result', [
            'score' => $score,
            'total' => $totalQuestions,
        ]);
// --- BAGIAN BARU: SIMPAN HASIL KE DATABASE ---
        // 3. Buat record baru di tabel quiz_results
        if ($totalQuestions > 0) {
            QuizResult::create([
                'user_id' => Auth::id(), // ID pengguna yang sedang login
                'score' => $score,
                'total_questions' => $totalQuestions,
            ]);
        }
        // ---------------------------------------------

        // Tetap tampilkan halaman hasil seperti biasa
        return view('quiz.result', compact('score', 'totalQuestions'));
    }
}