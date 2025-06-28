<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom 'is_active' setelah kolom 'remember_token' (atau kolom lain)
            // Tipe data boolean lebih efisien untuk menyimpan nilai true/false (1/0)
            // default(true) artinya setiap user baru akan otomatis aktif
            $table->boolean('is_active')->default(true)->after('remember_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Ini akan menghapus kolom jika migrasi di-rollback
            $table->dropColumn('is_active');
        });
    }
};