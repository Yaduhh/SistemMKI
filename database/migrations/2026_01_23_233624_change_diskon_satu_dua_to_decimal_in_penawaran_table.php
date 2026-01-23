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
        Schema::table('penawaran', function (Blueprint $table) {
            $table->decimal('diskon_satu', 5, 2)->nullable()->change();
            $table->decimal('diskon_dua', 5, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penawaran', function (Blueprint $table) {
            $table->integer('diskon_satu')->nullable()->change();
            $table->integer('diskon_dua')->nullable()->change();
        });
    }
};
