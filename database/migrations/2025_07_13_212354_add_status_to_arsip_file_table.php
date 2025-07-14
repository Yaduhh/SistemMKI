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
        Schema::table('arsip_file', function (Blueprint $table) {
            $table->enum('status', ['draft', 'on progress', 'done'])->default('draft')->after('status_deleted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('arsip_file', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
