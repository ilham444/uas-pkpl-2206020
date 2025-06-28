<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quiz_results', function (Blueprint $table) {
            $table->id();
            // Hubungkan dengan pengguna yang mengerjakan quiz
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('score'); // Skor yang didapat (jumlah jawaban benar)
            $table->integer('total_questions'); // Total soal saat itu
            // Opsional: Anda bisa menyimpan quiz_id jika quiz bisa berbeda-beda
            // $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->timestamps(); // Kapan quiz dikerjakan
        });
    }

    public function down()
    {
        Schema::dropIfExists('quiz_results');
    }
};