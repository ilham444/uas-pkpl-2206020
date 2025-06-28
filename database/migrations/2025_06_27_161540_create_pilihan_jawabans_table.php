// database/migrations/..._create_pilihan_jawabans_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pilihan_jawabans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('soal_id')->constrained('soals')->onDelete('cascade');
            $table->text('jawaban');
            $table->boolean('is_benar')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pilihan_jawabans');
    }
};