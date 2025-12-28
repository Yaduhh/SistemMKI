<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RotanSintetis extends Model
{
    use HasFactory;

    protected $table = 'rotan_sintetis';

    protected $fillable = [
        'code',
        'nama_produk',
        'slug',
        'satuan',
        'harga',
        'status_deleted',
        'created_by'
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'status_deleted' => 'boolean',
    ];

    // Relationship with User who created the rotan_sintetis
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Method to create unique slug
    public static function createUniqueSlug($slug)
    {
        $originalSlug = $slug;
        $count = 1;
        
        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        
        return $slug;
    }

    // Boot method to handle slug creation
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($rotanSintetis) {
            if (empty($rotanSintetis->slug)) {
                $rotanSintetis->slug = Str::slug($rotanSintetis->code);
            }
            $rotanSintetis->slug = static::createUniqueSlug($rotanSintetis->slug);
        });

        static::updating(function ($rotanSintetis) {
            if ($rotanSintetis->isDirty('slug')) {
                $rotanSintetis->slug = static::createUniqueSlug($rotanSintetis->slug);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status_deleted', false);
    }
}
