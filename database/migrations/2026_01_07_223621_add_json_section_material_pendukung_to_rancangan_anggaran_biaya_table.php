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
            $table->json('json_section_material_pendukung')->nullable()->after('json_pengeluaran_material_pendukung');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rancangan_anggaran_biaya', function (Blueprint $table) {
            $table->dropColumn('json_section_material_pendukung');
        });
    }
};
