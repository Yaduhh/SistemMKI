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
        'ppn',
        'json_syarat_kondisi',
        'logo',
        'created_by',
        'status',
        'status_deleted',
        'is_revisi',
        'revisi_from',
        'catatan_revisi',
    ];

    protected $casts = [
        'json_pemasangan' => 'array',
        'json_syarat_kondisi' => 'array',
        'tanggal_pemasangan' => 'date',
        'total' => 'float',
        'diskon' => 'float',
        'grand_total' => 'float',
        'ppn' => 'integer',
        'status' => 'integer',
        'status_deleted' => 'integer',
        'is_revisi' => 'boolean',
        'revisi_from' => 'integer',
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

    /**
     * Relasi ke pemasangan asli (jika ini adalah revisi)
     */
    public function pemasanganAsli()
    {
        return $this->belongsTo(Pemasangan::class, 'revisi_from');
    }

    /**
     * Relasi ke semua revisi (jika ini adalah pemasangan asli)
     * Hanya yang belum dihapus
     */
    public function revisi()
    {
        return $this->hasMany(Pemasangan::class, 'revisi_from')->where('status_deleted', 0);
    }

    /**
     * Cek apakah pemasangan bisa dibuat revisi
     */
    public function canCreateRevisi()
    {
        // Hapus suffix revisi jika ada untuk mendapatkan nomor asli
        $nomorAsli = preg_replace('/\s+R\d+$/', '', $this->nomor_pemasangan);
        
        // Cari jumlah revisi yang sudah ada untuk nomor asli ini (hanya yang belum dihapus)
        $jumlahRevisi = Pemasangan::where('nomor_pemasangan', 'like', $nomorAsli . '%')
            ->where('is_revisi', true)
            ->where('status_deleted', 0)
            ->count();
        
        // Maksimal 3 revisi
        return $jumlahRevisi < 3;
    }

    /**
     * Get nomor pemasangan tanpa suffix revisi
     */
    public function getNomorAsliAttribute()
    {
        return preg_replace('/\s+R\d+$/', '', $this->nomor_pemasangan);
    }

    /**
     * Get status revisi (R1, R2, R3)
     */
    public function getStatusRevisiAttribute()
    {
        if (!$this->is_revisi) {
            return null;
        }

        if (preg_match('/\s+R(\d+)$/', $this->nomor_pemasangan, $matches)) {
            return 'R' . $matches[1];
        }

        return null;
    }
}
