<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('daily_activities', function (Blueprint $table) {
            // Ubah kolom dokumentasi menjadi JSON
            $table->json('dokumentasi')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('daily_activities', function (Blueprint $table) {
            // Kembalikan ke string jika rollback
            $table->string('dokumentasi')->nullable()->change();
        });
    }
}; 