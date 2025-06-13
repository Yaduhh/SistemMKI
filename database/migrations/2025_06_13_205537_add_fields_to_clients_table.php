<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            // Add new fields
            $table->string('nama_perusahaan')->nullable()->after('notelp');
            $table->text('alamat')->nullable()->after('nama_perusahaan');
            
            // Add new JSON column
            $table->json('description_json')->nullable()->after('description');
        });

        // Migrate existing data
        DB::statement('UPDATE clients SET description_json = JSON_OBJECT("text", description) WHERE description IS NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            // Remove new fields
            $table->dropColumn(['nama_perusahaan', 'alamat', 'description_json']);
        });
    }
};
