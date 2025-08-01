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
        Schema::create('produk', function (Blueprint $table) {
            $table->id(); // id auto-increment
            $table->string('type'); // type - string
            $table->double('dimensi_lebar'); // dimensi_lebar - double
            $table->double('dimensi_tinggi')->nullable();
            $table->double('panjang'); // panjang - double
            $table->string('warna'); // warna - string
            $table->double('harga'); // harga - double
            $table->boolean('status_deleted')->default(false); // status_deleted - boolean
            $table->timestamps(); // created_at dan updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
