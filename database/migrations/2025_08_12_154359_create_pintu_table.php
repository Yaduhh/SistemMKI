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
        Schema::create('pintu', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('nama_produk');
            $table->string('slug')->unique();
            $table->decimal('lebar', 8, 2)->nullable();
            $table->decimal('tebal', 8, 2)->nullable();
            $table->decimal('tinggi', 8, 2)->nullable();
            $table->string('warna')->nullable();
            $table->decimal('harga_satuan', 12, 2)->default(0);
            $table->boolean('status_deleted')->default(false);
            $table->boolean('status_aksesoris')->default(false);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pintu');
    }
};
