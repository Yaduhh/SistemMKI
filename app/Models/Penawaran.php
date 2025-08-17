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
        'project',
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
        'penawaran_pintu',
        'is_revisi',
        'revisi_from',
        'catatan_revisi',
        'json_penawaran_pintu',
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
        'penawaran_pintu' => 'boolean',
        'is_revisi' => 'boolean',
        'revisi_from' => 'integer',
        'json_penawaran_pintu' => 'array',
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

    public function pemasangans()
    {
        return $this->hasMany(\App\Models\Pemasangan::class, 'id_penawaran');
    }

    public function rancanganAnggaranBiayas()
    {
        return $this->hasMany(\App\Models\RancanganAnggaranBiaya::class, 'penawaran_id');
    }

    /**
     * Relasi ke penawaran asli (jika ini adalah revisi)
     */
    public function penawaranAsli()
    {
        return $this->belongsTo(Penawaran::class, 'revisi_from');
    }

    /**
     * Relasi ke semua revisi (jika ini adalah penawaran asli)
     */
    public function revisi()
    {
        return $this->hasMany(Penawaran::class, 'revisi_from');
    }

    /**
     * Cek apakah penawaran bisa dibuat revisi
     */
    public function canCreateRevisi()
    {
        // Hapus suffix revisi jika ada untuk mendapatkan nomor asli
        $nomorAsli = preg_replace('/\s+R\d+$/', '', $this->nomor_penawaran);
        
        // Cari jumlah revisi yang sudah ada untuk nomor asli ini
        $jumlahRevisi = Penawaran::where('nomor_penawaran', 'like', $nomorAsli . '%')
            ->where('is_revisi', true)
            ->count();
        
        // Maksimal 3 revisi
        return $jumlahRevisi < 3;
    }

    /**
     * Get nomor penawaran tanpa suffix revisi
     */
    public function getNomorAsliAttribute()
    {
        return preg_replace('/\s+R\d+$/', '', $this->nomor_penawaran);
    }

    /**
     * Get status revisi (R1, R2, R3)
     */
    public function getStatusRevisiAttribute()
    {
        if (!$this->is_revisi) {
            return null;
        }

        if (preg_match('/\s+R(\d+)$/', $this->nomor_penawaran, $matches)) {
            return 'R' . $matches[1];
        }

        return null;
    }
}
