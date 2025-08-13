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
            $table->boolean('penawaran_pintu')->default(0)->after('json_produk');
            $table->json('json_penawaran_pintu')->nullable()->after('penawaran_pintu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penawaran', function (Blueprint $table) {
            $table->dropColumn(['penawaran_pintu', 'json_penawaran_pintu']);
        });
    }
};
