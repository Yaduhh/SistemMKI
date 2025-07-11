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
        Schema::create('rancangan_anggaran_biaya', function (Blueprint $table) {
            $table->id();
            $table->string('proyek', 255);
            $table->string('pekerjaan');
            $table->string('kontraktor');
            $table->string('lokasi');
            $table->json('json_pengeluaran_material_utama')->nullable();
            $table->json('json_pengeluaran_material_pendukung')->nullable();
            $table->json('json_pengeluaran_entertaiment')->nullable();
            $table->json('json_pengeluaran_akomodasi')->nullable();
            $table->json('json_pengeluaran_lainnya')->nullable();
            $table->json('json_pengeluaran_tukang')->nullable();
            $table->json('json_kerja_tambah')->nullable();
            $table->boolean('status_deleted')->default(false);
            $table->string('status')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rancangan_anggaran_biaya');
    }
};
