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
        Schema::table('daily_activities', function (Blueprint $table) {
            // Ubah kolom pihak_bersangkutan dari integer (foreign key) menjadi string
            $table->string('pihak_bersangkutan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daily_activities', function (Blueprint $table) {
            // Kembalikan ke integer jika rollback
            $table->unsignedBigInteger('pihak_bersangkutan')->nullable()->change();
        });
    }
};
