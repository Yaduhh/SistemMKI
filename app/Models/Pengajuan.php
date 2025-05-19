<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
     // Nama tabel (jika berbeda dari default pluralisasi)
    protected $table = 'pengajuan';

    // Kolom yang bisa diisi (fillable)
    protected $fillable = [
        'id_user',
        'nomor_pengajuan',
        'date_pengajuan',
        'judul_pengajuan',
        'diskon_satu',
        'diskon_dua',
        'diskon_tiga',
        'client',
        'nama_client',
        'title_produk',
        'title_aksesoris',
        'json_produk',
        'json_aksesoris', 
        'total_1',
        'total_2',
        'note',
        'ppn',
        'grand_total',
        'syarat_kondisi',
        'status',
        'status_deleted',
    ];

    protected $casts = [
        'syarat_kondisi' => 'array',
        'json_produk'    => 'array',
        'json_aksesoris' => 'array',
        'date_pengajuan' => 'date',
        'total_1'        => 'double',
        'total_2'        => 'double',
        'grand_total'    => 'double',
        'status_deleted' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
