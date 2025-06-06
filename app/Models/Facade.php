<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Facade extends Model
{
    use HasFactory;

    protected $table = 'facade';

    protected $fillable = [
        'code',
        'slug',
        'lebar',
        'tebal',
        'panjang',
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

        static::creating(function ($facade) {
            $baseSlug = Str::slug($facade->code);
            $count = static::where('slug', 'LIKE', $baseSlug . '%')->count();
            
            if ($count > 0) {
                $facade->slug = $baseSlug . '-' . ($count + 1);
            } else {
                $facade->slug = $baseSlug;
            }
        });
    }
} 