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
        Schema::table('pengajuan', function (Blueprint $table) {
            // Menambahkan foreign key constraint pada kolom id_user yang mengarah ke id di tabel users
            $table->foreign('id_user')
                  ->references('id') // Menunjuk ke kolom id di tabel users
                  ->on('users') // Tabel yang menjadi referensi
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            // Menghapus foreign key dan kolom id_user
            $table->dropForeign(['id_user']);
        });
    }
};
