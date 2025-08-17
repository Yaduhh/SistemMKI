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
        Schema::table('pintu', function (Blueprint $table) {
            // Hapus unique constraint dari kolom code
            $table->dropUnique(['code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pintu', function (Blueprint $table) {
            // Kembalikan unique constraint jika rollback
            $table->unique('code');
        });
    }
};
