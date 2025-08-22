<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemasangan extends Model
{
    protected $fillable = [
        'nomor_pemasangan',
        'tanggal_pemasangan',
        'id_penawaran',
        'id_client',
        'id_sales',
        'judul_pemasangan',
        'json_pemasangan',
        'total',
        'diskon',
        'grand_total',
        'json_syarat_kondisi',
        'logo',
        'created_by',
        'status',
        'status_deleted',
    ];

    protected $casts = [
        'json_pemasangan' => 'array',
        'json_syarat_kondisi' => 'array',
        'tanggal_pemasangan' => 'date',
        'total' => 'float',
        'diskon' => 'float',
        'grand_total' => 'float',
        'status' => 'integer',
        'status_deleted' => 'integer',
    ];

    protected $table = 'pemasangan';

    public function client()
    {
        return $this->belongsTo(\App\Models\Client::class, 'id_client');
    }

    public function sales()
    {
        return $this->belongsTo(\App\Models\User::class, 'id_sales');
    }

    public function penawaran()
    {
        return $this->belongsTo(\App\Models\Penawaran::class, 'id_penawaran');
    }
}
