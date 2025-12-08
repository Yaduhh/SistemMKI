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
        Schema::create('hollow', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('nama_produk');
            $table->string('slug')->unique();
            $table->string('satuan');
            $table->decimal('harga', 15, 2);
            $table->boolean('status_deleted')->default(false);
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
        Schema::dropIfExists('hollow');
    }
};
