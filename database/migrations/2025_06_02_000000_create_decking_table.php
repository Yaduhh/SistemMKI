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
        Schema::create('decking', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->double('lebar');
            $table->double('tebal');
            $table->double('panjang');
            $table->double('luas_btg');
            $table->double('luas_m2');
            $table->enum('satuan', ['mm', 'cm', 'm']);
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            
            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('decking');
    }
}; 