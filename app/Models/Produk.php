<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'produk';
    protected $fillable = [
        'type',
        'dimensi_lebar',
        'dimensi_tinggi',
        'panjang',
        'warna',
        'harga',
        'status_deleted',
        'nama_produk',
        'image_produk', 
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'dimensi_lebar' => 'double',
        'dimensi_tinggi' => 'double',
        'panjang' => 'double',
        'harga' => 'double',
        'status_deleted' => 'boolean',
    ];
}
