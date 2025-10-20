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
        'summary',
        'lokasi',
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
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * The timezone that should be used for date casting.
     *
     * @var string
     */
    protected $timezone = 'Asia/Jakarta';

    /**
     * Get the user that created the daily activity.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    /**
     * Get the client related to this daily activity.
     * Note: This relationship is only valid when pihak_bersangkutan contains a valid client ID.
     */
    public function client()
    {
        // Only return client relationship if pihak_bersangkutan is numeric (client ID)
        if (is_numeric($this->pihak_bersangkutan)) {
            return $this->belongsTo(Client::class, 'pihak_bersangkutan');
        }
        return null;
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
