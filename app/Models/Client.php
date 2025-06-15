<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'email',
        'notelp',
        'nama_perusahaan',
        'alamat',
        'description_json',
        'file_input',
        'status',
        'status_deleted',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'boolean',
        'status_deleted' => 'boolean',
        'description_json' => 'json',
    ];

    /**
     * Get the user that created the client.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the arsip files for the client.
     */
    public function arsipFiles()
    {
        return $this->hasMany(ArsipFile::class, 'id_client');
    }

    /**
     * Get the daily activities for the client.
     */
    public function dailyActivities()
    {
        return $this->hasMany(DailyActivity::class, 'pihak_bersangkutan');
    }

    /**
     * Scope a query to only include active clients.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope a query to only include non-deleted clients.
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('status_deleted', false);
    }

    /**
     * Get the description attribute.
     */
    public function getDescriptionAttribute()
    {
        if (!$this->description_json) {
            return [];
        }
        
        // Jika description_json sudah dalam bentuk array, langsung return
        if (is_array($this->description_json)) {
            return $this->description_json['items'] ?? [];
        }
        
        // Jika description_json dalam bentuk string, decode dulu
        $data = json_decode($this->description_json, true);
        return $data['items'] ?? [];
    }

    /**
     * Set the description attribute.
     */
    public function setDescriptionAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['description_json'] = json_encode(['items' => $value]);
        } else {
            $this->attributes['description_json'] = json_encode(['items' => [$value]]);
        }
    }
}