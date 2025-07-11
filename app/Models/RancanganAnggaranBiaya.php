<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RancanganAnggaranBiaya extends Model
{
    use HasFactory;

    protected $table = 'rancangan_anggaran_biaya';

    protected $fillable = [
        'proyek',
        'pekerjaan',
        'kontraktor',
        'lokasi',
        'json_pengeluaran_material_utama',
        'json_pengeluaran_material_pendukung',
        'json_pengeluaran_entertaiment',
        'json_pengeluaran_akomodasi',
        'json_pengeluaran_lainnya',
        'json_pengeluaran_tukang',
        'json_kerja_tambah',
        'status_deleted',
        'status',
        'created_by',
    ];

    protected $casts = [
        'json_pengeluaran_material_utama' => 'array',
        'json_pengeluaran_material_pendukung' => 'array',
        'json_pengeluaran_entertaiment' => 'array',
        'json_pengeluaran_akomodasi' => 'array',
        'json_pengeluaran_lainnya' => 'array',
        'json_pengeluaran_tukang' => 'array',
        'json_kerja_tambah' => 'array',
        'status_deleted' => 'boolean',
    ];
}
