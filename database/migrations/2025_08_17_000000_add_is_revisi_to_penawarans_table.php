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
            $table->boolean('is_revisi')->default(false)->after('penawaran_pintu');
            $table->unsignedBigInteger('revisi_from')->nullable()->after('is_revisi');
            $table->foreign('revisi_from')->references('id')->on('penawaran')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penawaran', function (Blueprint $table) {
            $table->dropForeign(['revisi_from']);
            $table->dropColumn(['is_revisi', 'revisi_from']);
        });
    }
};
