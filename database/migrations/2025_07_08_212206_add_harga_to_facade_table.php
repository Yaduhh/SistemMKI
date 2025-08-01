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
        Schema::table('facade', function (Blueprint $table) {
            $table->double('harga')->nullable()->after('luas_m2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facade', function (Blueprint $table) {
            $table->dropColumn('harga');
        });
    }
};
