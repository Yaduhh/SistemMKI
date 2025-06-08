<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ceiling extends Model
{
    use HasFactory;

    protected $table = 'ceiling';

    protected $fillable = [
        'code',
        'slug',
        'lebar',
        'tebal',
        'panjang',
        'luas_btg',
        'luas_m2',
        'satuan',
        'status_deleted',
        'created_by'
    ];

    protected $casts = [
        'lebar' => 'double',
        'tebal' => 'double',
        'panjang' => 'double',
        'luas_btg' => 'double',
        'luas_m2' => 'double',
        'status_deleted' => 'boolean',
    ];

    // Relationship with User who created the ceiling
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

        static::creating(function ($ceiling) {
            if (empty($ceiling->slug)) {
                $ceiling->slug = Str::slug($ceiling->code);
            }
            $ceiling->slug = static::createUniqueSlug($ceiling->slug);
        });

        static::updating(function ($ceiling) {
            if ($ceiling->isDirty('slug')) {
                $ceiling->slug = static::createUniqueSlug($ceiling->slug);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status_deleted', false);
    }
} 