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
        Schema::create('moduls', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('kategori_id')->constrained()->onDelete('cascade');
            $table->string('slug');
            $table->string('description');
            $table->integer('estimated');
            $table->string('thumbnail')->nullable();
            $table->timestamps();
        });

        Schema::table('materis', function (Blueprint $table) {
            // Menambahkan foreign key ke tabel kategoris
            // onDelete('cascade') berarti jika kategori dihapus, semua materi di dalamnya juga terhapus
            $table->integer('urutan')->unsigned()->nullable()->default(1);
            $table->foreignId('modul_id')->constrained()->onDelete('cascade')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materis', function (Blueprint $table) {
            $table->dropForeign(['modul_id']);
            $table->dropColumn('modul_id');
            $table->dropColumn('urutan');
        });
        Schema::dropIfExists('moduls');

    }
};
