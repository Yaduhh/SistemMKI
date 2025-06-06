<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Decking extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'decking';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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
        'status_aksesoris',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'lebar' => 'double',
        'tebal' => 'double',
        'panjang' => 'double',
        'luas_btg' => 'double',
        'luas_m2' => 'double',
        'status_deleted' => 'boolean',
        'status_aksesoris' => 'boolean',
    ];

    /**
     * Get the user that created the decking.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('status_deleted', false);
    }

    /**
     * Generate a unique slug for the decking.
     *
     * @param string $code
     * @return string
     */
    public static function generateUniqueSlug($code)
    {
        $slug = Str::slug($code);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($decking) {
            if (empty($decking->slug)) {
                $decking->slug = static::generateUniqueSlug($decking->code);
            }
        });

        static::updating(function ($decking) {
            if ($decking->isDirty('code') && !$decking->isDirty('slug')) {
                $decking->slug = static::generateUniqueSlug($decking->code);
            }
        });
    }
} 