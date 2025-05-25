<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratJalan extends Model
{
    use HasFactory;
    protected $table = 'surat_jalan';
    protected $fillable = [
        'nomor_surat',
        'no_po',
        'no_spp',
        'keterangan',
        'tujuan',
        'proyek',
        'penerima',
        'json',
        'author',
        'pengirim',
        'security',
        'diketahui',
        'disetujui',
        'diterima',
        'deleted_status',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author');
    }

}
