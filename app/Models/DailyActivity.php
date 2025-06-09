<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyActivity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'dokumentasi',
        'perihal',
        'pihak_bersangkutan',
        'komentar',
        'deleted_status',
        'created_by'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'komentar' => 'array',
        'dokumentasi' => 'array',
        'deleted_status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that created the daily activity.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Accessor untuk mendapatkan semua gambar dokumentasi
    public function getDokumentasiImagesAttribute()
    {
        if (!$this->dokumentasi) {
            return [];
        }
        return collect($this->dokumentasi)->map(function ($path) {
            return asset($path);
        })->toArray();
    }

    // Mutator untuk menyimpan gambar dokumentasi
    public function setDokumentasiAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['dokumentasi'] = json_encode($value);
        } else {
            $this->attributes['dokumentasi'] = $value;
        }
    }
}
