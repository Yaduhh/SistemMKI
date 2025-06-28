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
            $table->decimal('total_diskon', 15, 2)->nullable()->after('total');
            $table->decimal('total_diskon_1', 15, 2)->nullable()->after('total_diskon');
            $table->decimal('total_diskon_2', 15, 2)->nullable()->after('total_diskon_1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penawaran', function (Blueprint $table) {
            $table->dropColumn(['total_diskon', 'total_diskon_1', 'total_diskon_2']);
        });
    }
};
