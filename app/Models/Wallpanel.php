<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Wallpanel extends Model
{
    use HasFactory;

    protected $table = 'wallpanel';

    protected $fillable = [
        'code',
        'nama_produk',
        'slug',
        'lebar',
        'tebal',
        'panjang',
        'luas_btg',
        'luas_m2',
        'satuan',
        'harga',
        'status_deleted',
        'status_aksesoris',
        'created_by'
    ];

    protected $casts = [
        'lebar' => 'double',
        'tebal' => 'double',
        'panjang' => 'double',
        'luas_btg' => 'double',
        'luas_m2' => 'double',
        'harga' => 'double',
        'status_deleted' => 'boolean',
        'status_aksesoris' => 'boolean',
    ];

    // Relationship with User who created the wallpanel
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

        static::creating(function ($wallpanel) {
            if (empty($wallpanel->slug)) {
                $wallpanel->slug = Str::slug($wallpanel->code);
            }
            $wallpanel->slug = static::createUniqueSlug($wallpanel->slug);
        });

        static::updating(function ($wallpanel) {
            if ($wallpanel->isDirty('slug')) {
                $wallpanel->slug = static::createUniqueSlug($wallpanel->slug);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status_deleted', false);
    }
} 