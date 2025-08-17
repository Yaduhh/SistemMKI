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
        Schema::table('syarat_ketentuan', function (Blueprint $table) {
            $table->boolean('syarat_pintu')->default(0)->after('status_deleted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('syarat_ketentuan', function (Blueprint $table) {
            $table->dropColumn('syarat_pintu');
        });
    }
};
