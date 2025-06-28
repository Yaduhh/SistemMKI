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
        'diskon_satu',
        'diskon_dua',
        'ppn',
        'total',
        'total_diskon',
        'total_diskon_1',
        'total_diskon_2',
        'grand_total',
        'json_produk',
        'syarat_kondisi',
        'catatan',
        'status',
        'status_deleted',
        'created_by',
    ];

    protected $casts = [
        'tanggal_penawaran' => 'date',
        'diskon' => 'double',
        'diskon_satu' => 'integer',
        'diskon_dua' => 'integer',
        'ppn' => 'integer',
        'total' => 'double',
        'total_diskon' => 'decimal:2',
        'total_diskon_1' => 'decimal:2',
        'total_diskon_2' => 'decimal:2',
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

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
