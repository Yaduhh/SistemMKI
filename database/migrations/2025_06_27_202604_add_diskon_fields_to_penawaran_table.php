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
            $table->integer('diskon_satu')->nullable()->after('diskon');
            $table->integer('diskon_dua')->nullable()->after('diskon_satu');
            $table->unsignedBigInteger('created_by')->nullable()->after('diskon_dua');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penawaran', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn(['diskon_satu', 'diskon_dua', 'created_by']);
        });
    }
};
