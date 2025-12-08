<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Hollow extends Model
{
    use HasFactory;

    protected $table = 'hollow';

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

    // Relationship with User who created the hollow
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

        static::creating(function ($hollow) {
            if (empty($hollow->slug)) {
                $hollow->slug = Str::slug($hollow->code);
            }
            $hollow->slug = static::createUniqueSlug($hollow->slug);
        });

        static::updating(function ($hollow) {
            if ($hollow->isDirty('slug')) {
                $hollow->slug = static::createUniqueSlug($hollow->slug);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status_deleted', false);
    }
}
