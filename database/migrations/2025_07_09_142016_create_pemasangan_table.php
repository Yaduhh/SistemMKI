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
        Schema::create('pemasangan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pemasangan', 50)->unique(); // seperti nomor_penawaran, contoh: 024B/MKI/11/25
            $table->date('tanggal_pemasangan');
            $table->unsignedBigInteger('id_penawaran');
            $table->unsignedBigInteger('id_client');
            $table->unsignedBigInteger('id_sales'); // user
            $table->string('judul_pemasangan', 255);
            $table->json('json_pemasangan'); // item, satuan, qty, harga/satuan, total harga, sub_judul
            $table->decimal('total', 20, 2)->default(0);
            $table->decimal('diskon', 5, 2)->default(0); // persen
            $table->decimal('grand_total', 20, 2)->default(0);
            $table->json('json_syarat_kondisi')->nullable();
            $table->string('logo', 100)->nullable(); // MEGA KOMPOSIT INDONESIA atau WPC MAKMUR ABADI
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            $table->tinyInteger('status')->default(0); // 0=draft, 1=aktif, dst
            $table->tinyInteger('status_deleted')->default(0); // 0=aktif, 1=deleted

            // Foreign keys (optional, uncomment if needed)
            // $table->foreign('id_penawaran')->references('id')->on('penawaran')->onDelete('cascade');
            // $table->foreign('id_client')->references('id')->on('clients')->onDelete('cascade');
            // $table->foreign('id_sales')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemasangan');
    }
};
