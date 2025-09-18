<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RabDokumentasi extends Model
{
    protected $table = 'rab_dokumentasi';

    protected $fillable = [
        'rancangan_anggaran_biaya_id',
        'file_paths',
        'created_by',
        'status_deleted',
    ];

    protected $casts = [
        'file_paths' => 'array',
        'status_deleted' => 'boolean',
    ];

    public function rancanganAnggaranBiaya(): BelongsTo
    {
        return $this->belongsTo(RancanganAnggaranBiaya::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getFilePathsAttribute($value)
    {
        if (!$value) {
            return [];
        }
        $paths = json_decode($value, true);
        if (!is_array($paths)) {
            return [];
        }
        return collect($paths)->map(function ($path) {
            return asset('storage/' . $path);
        })->toArray();
    }

    public function setFilePathsAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['file_paths'] = json_encode($value);
        } else {
            $this->attributes['file_paths'] = $value;
        }
    }
}
