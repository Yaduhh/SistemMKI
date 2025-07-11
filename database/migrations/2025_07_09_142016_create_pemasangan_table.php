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
        if (!Schema::hasTable('pemasangan')) {
        Schema::create('pemasangan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pemasangan', 50)->unique(); // seperti nomor_penawaran, contoh: 024B/MKI/11/25
            $table->date('tanggal_pemasangan');
            $table->unsignedBigInteger('id_penawaran');
            $table->unsignedBigInteger('id_client');
            $table->unsignedBigInteger('id_sales'); // user
            $table->string('judul_pemasangan', 255);
            $table->json('json_pemasangan'); // item, satuan, qty, harga/satuan, total harga, sub_judul
            $table->decimal('total', 20, 2)->default(0);
            $table->decimal('diskon', 5, 2)->default(0); // persen
            $table->decimal('grand_total', 20, 2)->default(0);
            $table->json('json_syarat_kondisi')->nullable();
            $table->string('logo', 100)->nullable(); // MEGA KOMPOSIT INDONESIA atau WPC MAKMUR ABADI
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            $table->tinyInteger('status')->default(0); // 0=draft, 1=aktif, dst
            $table->tinyInteger('status_deleted')->default(0); // 0=aktif, 1=deleted
            });
        } else {
            // Jika sudah ada, pastikan struktur sesuai
            Schema::table('pemasangan', function (Blueprint $table) {
                // Tambahkan kolom jika belum ada
                if (!Schema::hasColumn('pemasangan', 'nomor_pemasangan')) {
                    $table->string('nomor_pemasangan', 50)->unique();
                }
                if (!Schema::hasColumn('pemasangan', 'tanggal_pemasangan')) {
                    $table->date('tanggal_pemasangan');
                }
                if (!Schema::hasColumn('pemasangan', 'id_penawaran')) {
                    $table->unsignedBigInteger('id_penawaran');
                }
                if (!Schema::hasColumn('pemasangan', 'id_client')) {
                    $table->unsignedBigInteger('id_client');
                }
                if (!Schema::hasColumn('pemasangan', 'id_sales')) {
                    $table->unsignedBigInteger('id_sales');
                }
                if (!Schema::hasColumn('pemasangan', 'judul_pemasangan')) {
                    $table->string('judul_pemasangan', 255);
                }
                if (!Schema::hasColumn('pemasangan', 'json_pemasangan')) {
                    $table->json('json_pemasangan');
                }
                if (!Schema::hasColumn('pemasangan', 'total')) {
                    $table->decimal('total', 20, 2)->default(0);
                }
                if (!Schema::hasColumn('pemasangan', 'diskon')) {
                    $table->decimal('diskon', 5, 2)->default(0);
                }
                if (!Schema::hasColumn('pemasangan', 'grand_total')) {
                    $table->decimal('grand_total', 20, 2)->default(0);
                }
                if (!Schema::hasColumn('pemasangan', 'json_syarat_kondisi')) {
                    $table->json('json_syarat_kondisi')->nullable();
                }
                if (!Schema::hasColumn('pemasangan', 'logo')) {
                    $table->string('logo', 100)->nullable();
                }
                if (!Schema::hasColumn('pemasangan', 'created_by')) {
                    $table->unsignedBigInteger('created_by');
                }
                if (!Schema::hasColumn('pemasangan', 'status')) {
                    $table->tinyInteger('status')->default(0);
                }
                if (!Schema::hasColumn('pemasangan', 'status_deleted')) {
                    $table->tinyInteger('status_deleted')->default(0);
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemasangan');
    }
};
