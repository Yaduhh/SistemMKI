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
            $table->unsignedBigInteger('supervisi_id')->nullable()->after('id');
            $table->foreign('supervisi_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rancangan_anggaran_biaya', function (Blueprint $table) {
            $table->dropForeign(['supervisi_id']);
            $table->dropColumn('supervisi_id');
        });
    }
};
