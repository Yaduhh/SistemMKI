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
        'penawaran_id',
        'pemasangan_id',
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

    // Mutators to ensure arrays are never null
    public function setJsonPengeluaranMaterialUtamaAttribute($value)
    {
        $this->attributes['json_pengeluaran_material_utama'] = json_encode($value ?? []);
    }

    public function setJsonPengeluaranMaterialPendukungAttribute($value)
    {
        $this->attributes['json_pengeluaran_material_pendukung'] = json_encode($value ?? []);
    }

    public function setJsonPengeluaranEntertaimentAttribute($value)
    {
        $this->attributes['json_pengeluaran_entertaiment'] = json_encode($value ?? []);
    }

    public function setJsonPengeluaranAkomodasiAttribute($value)
    {
        $this->attributes['json_pengeluaran_akomodasi'] = json_encode($value ?? []);
    }

    public function setJsonPengeluaranLainnyaAttribute($value)
    {
        $this->attributes['json_pengeluaran_lainnya'] = json_encode($value ?? []);
    }

    public function setJsonPengeluaranTukangAttribute($value)
    {
        $this->attributes['json_pengeluaran_tukang'] = json_encode($value ?? []);
    }

    public function setJsonKerjaTambahAttribute($value)
    {
        $this->attributes['json_kerja_tambah'] = json_encode($value ?? []);
    }

    // Relationships
    public function penawaran()
    {
        return $this->belongsTo(Penawaran::class);
    }

    public function pemasangan()
    {
        return $this->belongsTo(Pemasangan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status_deleted', false);
    }
}
