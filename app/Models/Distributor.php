<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Distributor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'distributor';

    protected $fillable = [
        'nama_distributor',
        'lokasi',
        'profile',
        'status',
        'status_deleted'
    ];

    protected $casts = [
        'status' => 'boolean',
        'status_deleted' => 'boolean'
    ];
} 