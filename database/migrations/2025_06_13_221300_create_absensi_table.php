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
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status_absen')->default(0); 
            $table->boolean('deleted_status')->default(false);
            $table->date('tgl_absen');
            $table->tinyInteger('count')->default(0);
            $table->unsignedBigInteger('id_daily_activity')->nullable();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->foreign('id_daily_activity')
                  ->references('id')
                  ->on('daily_activities')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
}; 