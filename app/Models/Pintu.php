<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Pintu extends Model
{
    protected $table = 'pintu';

    protected $fillable = [
        'code',
        'nama_produk',
        'slug',
        'lebar',
        'tebal',
        'tinggi',
        'warna',
        'harga_satuan',
        'status_deleted',
        'status_aksesoris',
        'created_by',
    ];

    protected $casts = [
        'lebar' => 'decimal:2',
        'tebal' => 'decimal:2',
        'tinggi' => 'decimal:2',
        'harga_satuan' => 'decimal:2',
        'status_deleted' => 'boolean',
        'status_aksesoris' => 'boolean',
        'created_by' => 'integer',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Generate unique slug dengan increment jika sudah ada
     */
    protected static function generateUniqueSlug($namaProduk)
    {
        $baseSlug = Str::slug($namaProduk);
        $slug = $baseSlug;
        $counter = 1;

        // Debug: log untuk melihat proses
        \Log::info("Generating slug for: " . $namaProduk);
        \Log::info("Base slug: " . $baseSlug);

        // Cek apakah slug sudah ada (termasuk yang sudah dihapus)
        while (self::withoutGlobalScopes()->where('slug', $slug)->exists()) {
            \Log::info("Slug exists: " . $slug . ", trying next...");
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        \Log::info("Final slug: " . $slug);
        return $slug;
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('notDeleted', function ($query) {
            $query->where('status_deleted', false);
        });

        static::creating(function ($pintu) {
            // Selalu generate slug baru saat creating
            if (empty($pintu->slug)) {
                $pintu->slug = self::generateUniqueSlug($pintu->nama_produk);
            }
        });

        static::updating(function ($pintu) {
            // Update slug jika nama_produk berubah
            if ($pintu->isDirty('nama_produk')) {
                $pintu->slug = self::generateUniqueSlug($pintu->nama_produk);
            }
        });
    }
}
