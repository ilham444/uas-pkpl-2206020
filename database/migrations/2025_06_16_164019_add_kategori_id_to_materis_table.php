<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::table('materis', function (Blueprint $table) {
        //     // Menambahkan foreign key ke tabel kategoris
        //     // onDelete('cascade') berarti jika kategori dihapus, semua materi di dalamnya juga terhapus
        //     $table->foreignId('kategori_id')->constrained()->onDelete('cascade')->after('id');
        // });
    }

    public function down(): void
    {
        // Schema::table('materis', function (Blueprint $table) {
        //     $table->dropForeign(['kategori_id']);
        //     $table->dropColumn('kategori_id');
        // });
    }
};
