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
}
