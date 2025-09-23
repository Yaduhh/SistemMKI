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
        Schema::create('file_managers', function (Blueprint $table) {
            $table->id();
            $table->string('original_name'); // Nama file asli
            $table->string('file_name'); // Nama file yang disimpan di storage
            $table->string('file_path'); // Path file relatif dari storage
            $table->string('file_url')->nullable(); // URL lengkap file
            $table->string('mime_type'); // Tipe MIME file (image/jpeg, application/pdf, dll)
            $table->string('file_extension'); // Ekstensi file (.jpg, .pdf, .mp4, dll)
            $table->enum('file_type', ['image', 'document', 'video', 'audio', 'other']); // Kategori file
            $table->bigInteger('file_size'); // Ukuran file dalam bytes
            $table->string('file_size_human')->nullable(); // Ukuran file dalam format human readable (1.5 MB)
            $table->string('title')->nullable(); // Judul/deskripsi file
            $table->text('description')->nullable(); // Deskripsi file
            $table->string('alt_text')->nullable(); // Alt text untuk aksesibilitas
            $table->json('metadata')->nullable(); // Metadata tambahan (dimensi gambar, durasi video, dll)
            $table->string('folder_path')->nullable(); // Path folder untuk organisasi file
            $table->boolean('is_public')->default(false); // Apakah file bisa diakses publik
            $table->boolean('is_featured')->default(false); // Apakah file featured/pin
            $table->integer('download_count')->default(0); // Jumlah download
            $table->integer('view_count')->default(0); // Jumlah view
            $table->timestamp('last_accessed_at')->nullable(); // Waktu terakhir diakses
            $table->unsignedBigInteger('uploaded_by'); // ID user yang upload
            $table->boolean('status_deleted')->default(false); // Soft delete
            $table->timestamps();
            
            // Indexes
            $table->index(['file_type', 'status_deleted']);
            $table->index(['uploaded_by', 'status_deleted']);
            $table->index(['is_public', 'status_deleted']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_managers');
    }
};
