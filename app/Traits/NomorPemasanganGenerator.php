<?php

namespace App\Traits;

use App\Models\Pemasangan;

trait NomorPemasanganGenerator
{
    /**
     * Generate nomor revisi pemasangan
     * Format: XXXB/MKI/MM/YY R1, R2, R3
     * 
     * @param string $nomorAsli
     * @return string
     */
    protected function generateNomorRevisiPemasangan($nomorAsli)
    {
        // Cari jumlah revisi yang sudah ada untuk nomor ini (hanya yang belum dihapus)
        $jumlahRevisi = Pemasangan::where('nomor_pemasangan', 'like', $nomorAsli . '%')
            ->where('is_revisi', true)
            ->where('status_deleted', 0)
            ->count();
        
        // Maksimal 3 revisi
        if ($jumlahRevisi >= 3) {
            throw new \Exception('Maksimal revisi hanya 3 kali');
        }
        
        $nomorRevisi = $jumlahRevisi + 1;
        return $nomorAsli . ' R' . $nomorRevisi;
    }

    /**
     * Cek apakah pemasangan bisa direvisi
     * 
     * @param string $nomorPemasangan
     * @return bool
     */
    protected function canCreateRevisiPemasangan($nomorPemasangan)
    {
        // Hapus suffix revisi jika ada
        $nomorAsli = preg_replace('/\s+R\d+$/', '', $nomorPemasangan);
        
        // Cari jumlah revisi yang sudah ada (hanya yang belum dihapus)
        $jumlahRevisi = Pemasangan::where('nomor_pemasangan', 'like', $nomorAsli . '%')
            ->where('is_revisi', true)
            ->where('status_deleted', 0)
            ->count();
        
        return $jumlahRevisi < 3;
    }
}
