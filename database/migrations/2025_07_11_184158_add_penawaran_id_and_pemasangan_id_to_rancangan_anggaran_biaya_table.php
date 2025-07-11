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
            $table->unsignedBigInteger('penawaran_id')->nullable()->after('id');
            $table->unsignedBigInteger('pemasangan_id')->nullable()->after('penawaran_id');

            $table->foreign('penawaran_id')->references('id')->on('penawaran')->onDelete('set null');
            $table->foreign('pemasangan_id')->references('id')->on('pemasangan')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rancangan_anggaran_biaya', function (Blueprint $table) {
            $table->dropForeign(['penawaran_id']);
            $table->dropForeign(['pemasangan_id']);
            $table->dropColumn(['penawaran_id', 'pemasangan_id']);
        });
    }
};
