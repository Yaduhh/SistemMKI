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
        Schema::create('penawaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user')->nullable(); // sales/user
            $table->unsignedBigInteger('id_client')->nullable(); // relasi ke client
            $table->string('nomor_penawaran')->nullable();
            $table->date('tanggal_penawaran')->nullable();
            $table->string('judul_penawaran')->nullable();
            $table->double('diskon')->nullable();
            $table->integer('ppn')->nullable();
            $table->double('total')->nullable();
            $table->double('grand_total')->nullable();
            $table->text('json_produk')->nullable(); // detail produk (bisa multi model)
            $table->text('syarat_kondisi')->nullable();
            $table->text('catatan')->nullable();
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
        Schema::dropIfExists('penawaran');
    }
};
