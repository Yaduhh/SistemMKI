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
        Schema::create('flooring', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('slug')->unique();
            $table->double('lebar');
            $table->double('tebal');
            $table->double('panjang');
            $table->enum('satuan', ['mm', 'cm', 'm'])->default('mm');
            $table->double('luas_btg');
            $table->double('luas_m2');
            $table->boolean('status_deleted')->default(false);
            $table->timestamps();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flooring');
    }
}; 