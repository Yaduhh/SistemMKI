<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('decking', function (Blueprint $table) {
            $table->boolean('status_deleted')->default(false)->after('luas_m2');
        });
    }

    public function down()
    {
        Schema::table('decking', function (Blueprint $table) {
            $table->dropColumn('status_deleted');
        });
    }
}; 