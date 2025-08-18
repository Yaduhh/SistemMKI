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
        Schema::table('rancangan_anggaran_biaya', function (Blueprint $table) {
            $table->boolean('penawaran_pintu')->default(0)->after('pemasangan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rancangan_anggaran_biaya', function (Blueprint $table) {
            $table->dropColumn('penawaran_pintu');
        });
    }
};
