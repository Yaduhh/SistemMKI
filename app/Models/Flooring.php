<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Flooring extends Model
{
    use HasFactory;

    protected $table = 'flooring';

    protected $fillable = [
        'code',
        'slug',
        'lebar',
        'tebal',
        'panjang',
        'satuan',
        'luas_btg',
        'luas_m2',
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

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('status_deleted', false);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($flooring) {
            $flooring->slug = static::generateUniqueSlug($flooring->code);
        });

        static::updating(function ($flooring) {
            if ($flooring->isDirty('code')) {
                $flooring->slug = static::generateUniqueSlug($flooring->code, $flooring->id);
            }
        });
    }

    protected static function generateUniqueSlug($code, $id = null)
    {
        $baseSlug = Str::slug($code);
        $slug = $baseSlug;
        $counter = 1;

        while (static::where('slug', $slug)
            ->when($id, function ($query) use ($id) {
                return $query->where('id', '!=', $id);
            })
            ->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
} 