// database/migrations/..._create_soals_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('soals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('latihan_id')->constrained('latihans')->onDelete('cascade');
            $table->text('pertanyaan');
            
            // === PASTIKAN DUA KOLOM INI ADA ===
            // Kolom ini yang menyebabkan error karena tidak ditemukan
            $table->enum('tipe_media', ['none', 'video', 'audio'])->default('none');
            $table->string('url_media')->nullable();
            
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soals');
    }
};