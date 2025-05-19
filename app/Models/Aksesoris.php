<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aksesoris extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak sesuai konvensi
    protected $table = 'aksesoris';

    // Tentukan atribut yang dapat diisi
    protected $fillable = [
        'type',
        'satuan',
        'harga',
        'status',
        'status_deleted',
    ];

    // Tentukan tipe data untuk atribut tertentu jika diperlukan
    protected $casts = [
        'harga' => 'double',
        'status' => 'boolean',
        'status_deleted' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($aksesoris) {
            // Set default value for status_deleted if not provided
            if (is_null($aksesoris->status_deleted)) {
                $aksesoris->status_deleted = false;
            }
        });
    }
}
