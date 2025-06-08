<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penawaran extends Model
{
    use HasFactory;

    protected $table = 'penawaran';

    protected $fillable = [
        'id_user',
        'id_client',
        'nomor_penawaran',
        'tanggal_penawaran',
        'judul_penawaran',
        'diskon',
        'ppn',
        'total',
        'grand_total',
        'json_produk',
        'syarat_kondisi',
        'catatan',
        'status',
        'status_deleted',
    ];

    protected $casts = [
        'tanggal_penawaran' => 'date',
        'diskon' => 'double',
        'ppn' => 'integer',
        'total' => 'double',
        'grand_total' => 'double',
        'json_produk' => 'array',
        'syarat_kondisi' => 'array',
        'status' => 'integer',
        'status_deleted' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }
}
