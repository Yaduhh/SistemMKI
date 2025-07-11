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
        // Add status_aksesoris to flooring table
        Schema::table('flooring', function (Blueprint $table) {
            $table->boolean('status_aksesoris')->default(false)->after('status_deleted');
        });

        // Add status_aksesoris to facade table
        Schema::table('facade', function (Blueprint $table) {
            $table->boolean('status_aksesoris')->default(false)->after('status_deleted');
        });

        // Add status_aksesoris to wallpanel table
        Schema::table('wallpanel', function (Blueprint $table) {
            $table->boolean('status_aksesoris')->default(false)->after('status_deleted');
        });

        // Add status_aksesoris to ceiling table
        Schema::table('ceiling', function (Blueprint $table) {
            $table->boolean('status_aksesoris')->default(false)->after('status_deleted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove status_aksesoris from flooring table
        Schema::table('flooring', function (Blueprint $table) {
            $table->dropColumn('status_aksesoris');
        });

        // Remove status_aksesoris from facade table
        Schema::table('facade', function (Blueprint $table) {
            $table->dropColumn('status_aksesoris');
        });

        // Remove status_aksesoris from wallpanel table
        Schema::table('wallpanel', function (Blueprint $table) {
            $table->dropColumn('status_aksesoris');
        });

        // Remove status_aksesoris from ceiling table
        Schema::table('ceiling', function (Blueprint $table) {
            $table->dropColumn('status_aksesoris');
        });
    }
};
