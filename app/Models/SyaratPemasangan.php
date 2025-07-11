<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class SyaratPemasangan extends Model
{
    protected $table = 'syarat_pemasangan';
    
    protected $fillable = [
        'syarat',
        'status_deleted'
    ];

    protected $casts = [
        'status_deleted' => 'boolean',
    ];

    /**
     * Scope untuk mengambil data yang tidak dihapus
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status_deleted', false);
    }

    /**
     * Scope untuk mengambil data yang dihapus
     */
    public function scopeDeleted(Builder $query): void
    {
        $query->where('status_deleted', true);
    }
}
