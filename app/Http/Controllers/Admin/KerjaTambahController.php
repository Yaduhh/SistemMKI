<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RancanganAnggaranBiaya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KerjaTambahController extends Controller
{
    public function index(Request $request)
    {
        $kerjaTambahData = [];
        
        $rabs = RancanganAnggaranBiaya::whereNotNull('json_kerja_tambah')
            ->where('json_kerja_tambah', '!=', 'null')
            ->where('status', '!=', 'selesai')
            ->get();
            
        foreach ($rabs as $rab) {
            // Get the data - model cast should handle JSON decoding
            $kerjaTambah = $rab->json_kerja_tambah;
            
            // If it's not an array, skip this RAB
            if (!is_array($kerjaTambah)) {
                continue;
            }
            
            foreach ($kerjaTambah as $section) {
                if (isset($section['termin']) && is_array($section['termin'])) {
                    foreach ($section['termin'] as $termin) {
                        $kerjaTambahData[] = [
                            'id' => $rab->id,
                            'proyek' => $rab->proyek,
                            'pekerjaan' => $rab->pekerjaan,
                            'kontraktor' => $rab->kontraktor,
                            'lokasi' => $rab->lokasi,
                            'tanggal' => $termin['tanggal'] ?? '-',
                            'kredit' => $termin['kredit'] ?? 0,
                            'sisa' => $termin['sisa'] ?? 0,
                            'persentase' => $termin['persentase'] ?? '-',
                            'status' => $termin['status'] ?? 'Pengajuan',
                            'debet' => $section['debet'] ?? 0
                        ];
                    }
                }
            }
        }

        // Filter berdasarkan status jika ada
        if ($request->filled('status_filter')) {
            $kerjaTambahData = collect($kerjaTambahData)->filter(function ($kerjaTambah) use ($request) {
                return $kerjaTambah['status'] === $request->status_filter;
            })->values()->toArray();
        }

        // Sort by tanggal descending
        $kerjaTambahData = collect($kerjaTambahData)->sortByDesc('tanggal')->values()->toArray();
        
        return view('admin.kerja-tambah.index', compact('kerjaTambahData'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pengajuan,Disetujui,Ditolak'
        ]);

        try {
            DB::beginTransaction();
            
            $rab = RancanganAnggaranBiaya::findOrFail($id);
            
            // Get the current data - model cast should handle JSON decoding
            $kerjaTambah = $rab->json_kerja_tambah;
            
            // If it's not an array, initialize as empty array
            if (!is_array($kerjaTambah)) {
                $kerjaTambah = [];
            }
            
            $updated = false;
            foreach ($kerjaTambah as &$section) {
                if (isset($section['termin']) && is_array($section['termin'])) {
                    foreach ($section['termin'] as &$termin) {
                        if (isset($termin['tanggal']) && $termin['tanggal'] === $request->tanggal &&
                            isset($termin['kredit']) && $termin['kredit'] == $request->kredit) {
                            $termin['status'] = $request->status;
                            $updated = true;
                            break 2;
                        }
                    }
                }
            }
            
            if ($updated) {
                // Update the model - the mutator will handle JSON encoding
                $rab->json_kerja_tambah = $kerjaTambah;
                $rab->save();
                DB::commit();
                return redirect()->route('admin.kerja-tambah.index')
                    ->with('success', 'Status termin kerja tambah berhasil diperbarui');
            }
            
            DB::rollback();
            return redirect()->route('admin.kerja-tambah.index')
                ->with('error', 'Data tidak ditemukan');
            
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('admin.kerja-tambah.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
