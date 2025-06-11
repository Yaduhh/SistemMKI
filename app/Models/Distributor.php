<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

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

    protected static function boot()
    {
        parent::boot();

        // Log when distributor is created
        static::created(function ($distributor) {
            Log::info('Distributor created', [
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name ?? 'System',
                'distributor_id' => $distributor->id,
                'distributor_name' => $distributor->nama_distributor,
                'lokasi' => $distributor->lokasi,
                'status' => $distributor->status,
                'action' => 'created',
                'timestamp' => now()
            ]);
        });

        // Log when distributor is updated
        static::updated(function ($distributor) {
            $changes = $distributor->getChanges();
            $original = $distributor->getOriginal();

            Log::info('Distributor updated', [
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name ?? 'System',
                'distributor_id' => $distributor->id,
                'distributor_name' => $distributor->nama_distributor,
                'changes' => $changes,
                'original' => $original,
                'action' => 'updated',
                'timestamp' => now()
            ]);
        });

        // Log when distributor is deleted
        static::deleted(function ($distributor) {
            Log::info('Distributor deleted', [
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name ?? 'System',
                'distributor_id' => $distributor->id,
                'distributor_name' => $distributor->nama_distributor,
                'action' => 'deleted',
                'timestamp' => now()
            ]);
        });
    }

    // Helper method to get status text
    public function getStatusTextAttribute()
    {
        return $this->status ? 'Aktif' : 'Nonaktif';
    }

    // Helper method to get status badge class
    public function getStatusBadgeClassAttribute()
    {
        return $this->status 
            ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
            : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
    }
} 