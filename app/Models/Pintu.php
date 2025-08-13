<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pintu extends Model
{
    protected $table = 'pintu';

    protected $fillable = [
        'code',
        'nama_produk',
        'slug',
        'lebar',
        'tebal',
        'tinggi',
        'warna',
        'harga_satuan',
        'status_deleted',
        'status_aksesoris',
        'created_by',
    ];

    protected $casts = [
        'lebar' => 'decimal:2',
        'tebal' => 'decimal:2',
        'tinggi' => 'decimal:2',
        'harga_satuan' => 'decimal:2',
        'status_deleted' => 'boolean',
        'status_aksesoris' => 'boolean',
        'created_by' => 'integer',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('notDeleted', function ($query) {
            $query->where('status_deleted', false);
        });

        static::creating(function ($pintu) {
            if (empty($pintu->slug)) {
                $pintu->slug = \Str::slug($pintu->nama_produk);
            }
        });

        static::updating(function ($pintu) {
            if ($pintu->isDirty('nama_produk') && empty($pintu->slug)) {
                $pintu->slug = \Str::slug($pintu->nama_produk);
            }
        });
    }
}
