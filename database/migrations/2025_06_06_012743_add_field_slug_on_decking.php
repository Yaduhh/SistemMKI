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
        Schema::table('decking', function (Blueprint $table) {
            $table->string('slug')->unique()->after('code');
            $table->boolean('status_aksesoris')->default(false)->after('status_deleted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('decking', function (Blueprint $table) {
            $table->dropColumn(['slug', 'status_aksesoris']);
        });
    }
}; 