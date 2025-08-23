<?php

namespace App\Traits;

use App\Models\Penawaran;

trait NomorPenawaranGenerator
{
    /**
     * Generate nomor penawaran otomatis berdasarkan bulan
     * Format: XX/MKI/MM/YY (XX = nomor urut bulanan)
     * 
     * @return string
     */
    protected function generateNomorPenawaran()
    {
        $currentMonth = date('m');
        $currentYear = date('y');
        
        // Cari penawaran terakhir di bulan yang sama (TANPA revisi)
        $lastPenawaranThisMonth = Penawaran::whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->where('is_revisi', false) // Hanya penawaran asli, bukan revisi
            ->latest()
            ->first();
        
        // Jika ada penawaran di bulan ini, increment nomor
        if ($lastPenawaranThisMonth) {
            // Ambil nomor dari format "0X/MKI/MM/YY" atau "0XX/MKI/MM/YY"
            $nomorStr = $lastPenawaranThisMonth->nomor_penawaran;
            // Cari posisi "/" pertama untuk memisahkan nomor dari prefix
            $slashPos = strpos($nomorStr, '/');
            if ($slashPos !== false) {
                $lastNumber = (int)substr($nomorStr, 0, $slashPos);
            } else {
                $lastNumber = 0;
            }
            $number = $lastNumber + 1;
        } else {
            // Jika bulan baru, mulai dari 1
            $number = 1;
        }
        
        // Format nomor penawaran: XX/MKI/MM/YY (dengan leading zero)
        $prefix = 'A/MKI/' . $currentMonth . '/' . $currentYear;
        return '0' . $number . $prefix;
    }

    /**
     * Generate nomor revisi berdasarkan penawaran asli
     * Format: XX/MKI/MM/YY R1, R2, R3
     * 
     * @param string $nomorAsli
     * @return string
     */
    protected function generateNomorRevisi($nomorAsli)
    {
        // Cari jumlah revisi yang sudah ada untuk nomor ini
        $jumlahRevisi = Penawaran::where('nomor_penawaran', 'like', $nomorAsli . '%')
            ->where('is_revisi', true)
            ->count();
        
        // Maksimal 3 revisi
        if ($jumlahRevisi >= 3) {
            throw new \Exception('Maksimal revisi hanya 3 kali');
        }
        
        $nomorRevisi = $jumlahRevisi + 1;
        return $nomorAsli . ' R' . $nomorRevisi;
    }

    /**
     * Cek apakah penawaran bisa direvisi
     * 
     * @param string $nomorPenawaran
     * @return bool
     */
    protected function canCreateRevisi($nomorPenawaran)
    {
        // Hapus suffix revisi jika ada
        $nomorAsli = preg_replace('/\s+R\d+$/', '', $nomorPenawaran);
        
        // Cari jumlah revisi yang sudah ada
        $jumlahRevisi = Penawaran::where('nomor_penawaran', 'like', $nomorAsli . '%')
            ->where('is_revisi', true)
            ->count();
        
        return $jumlahRevisi < 3;
    }
}
