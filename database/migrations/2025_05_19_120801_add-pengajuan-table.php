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
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->string('nomor_pengajuan')->nullable();
            $table->date('date_pengajuan')->nullable();
            $table->string('judul_pengajuan')->nullable();
            $table->integer('diskon_satu')->nullable();
            $table->integer('diskon_dua')->nullable();
            $table->integer('diskon_tiga')->nullable();
            $table->string('client')->nullable();
            $table->string('nama_client')->nullable();
            $table->string('title_produk')->nullable();
            $table->string('title_aksesoris')->nullable();
            $table->text('json_produk')->nullable();
            $table->double('total_1')->nullable();
            $table->double('total_2')->nullable();
            $table->text('note')->nullable();
            $table->integer('ppn')->nullable();
            $table->double('grand_total')->nullable();
            $table->text('syarat_kondisi')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->boolean('status_deleted')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan');
    }
};
