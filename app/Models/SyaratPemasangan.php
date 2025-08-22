<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class SyaratPemasangan extends Model
{
    protected $table = 'syarat_pemasangan';
    
    protected $fillable = [
        'syarat',
        'syarat_pintu',
        'status_deleted'
    ];

    protected $casts = [
        'status_deleted' => 'boolean',
        'syarat_pintu' => 'integer',
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

    /**
     * Scope untuk syarat pemasangan biasa (bukan pintu)
     */
    public function scopeRegular(Builder $query): void
    {
        $query->where('syarat_pintu', 0);
    }

    /**
     * Scope untuk syarat pemasangan pintu
     */
    public function scopeDoor(Builder $query): void
    {
        $query->where('syarat_pintu', 1);
    }
}
