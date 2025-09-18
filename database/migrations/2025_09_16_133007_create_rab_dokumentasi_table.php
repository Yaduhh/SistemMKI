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
        Schema::create('rab_dokumentasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rancangan_anggaran_biaya_id');
            $table->json('file_paths')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->boolean('status_deleted')->default(false);
            $table->timestamps();

            $table->foreign('rancangan_anggaran_biaya_id')->references('id')->on('rancangan_anggaran_biaya')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rab_dokumentasi');
    }
};
