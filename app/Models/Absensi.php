<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';
    
    protected $fillable = [
        'status_absen',
        'deleted_status',
        'tgl_absen',
        'count',
        'id_daily_activity',
        'id_user'
    ];

    protected $casts = [
        'tgl_absen' => 'date',
        'deleted_status' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function dailyActivity()
    {
        return $this->belongsTo(DailyActivity::class, 'id_daily_activity');
    }
} 