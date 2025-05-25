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
        Schema::create('surat_jalan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat', 255);
            $table->string('no_po', 255);
            $table->string('no_spp', 255);
            $table->string('keterangan', 255);
            $table->string('tujuan', 255);
            $table->string('proyek', 255);
            $table->string('penerima', 255);
            $table->json('json');
            $table->unsignedBigInteger('author');
            $table->string('pengirim', 255);
            $table->string('security', 255);
            $table->string('diketahui', 255);
            $table->string('disetujui', 255);
            $table->string('diterima', 255);
            $table->timestamps();

            $table->foreign('author')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_jalan');
    }
};
