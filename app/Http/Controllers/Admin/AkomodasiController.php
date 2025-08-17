<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RancanganAnggaranBiaya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AkomodasiController extends Controller
{
    public function index(Request $request)
    {
        $akomodasis = RancanganAnggaranBiaya::whereNotNull('json_pengeluaran_akomodasi')
            ->where('json_pengeluaran_akomodasi', '!=', '[]')
            ->get()
            ->map(function ($rab) {
                $akomodasiData = [];
                if (isset($rab->json_pengeluaran_akomodasi) && is_array($rab->json_pengeluaran_akomodasi)) {
                    foreach ($rab->json_pengeluaran_akomodasi as $mrIndex => $mrGroup) {
                        // Skip MR jika tidak ada data yang valid
                        if (empty($mrGroup['mr']) || $mrGroup['mr'] === null || $mrGroup['mr'] === '') {
                            continue;
                        }
                        
                        if (isset($mrGroup['materials']) && is_array($mrGroup['materials'])) {
                            foreach ($mrGroup['materials'] as $materialIndex => $material) {
                                // Skip material jika semua field penting null/kosong
                                if (empty($material['supplier']) && 
                                    empty($material['item']) && 
                                    empty($material['qty']) && 
                                    empty($material['satuan']) && 
                                    empty($material['harga_satuan']) && 
                                    empty($material['sub_total'])) {
                                    continue;
                                }
                                
                                $akomodasiData[] = [
                                    'rab_id' => $rab->id,
                                    'rab_proyek' => $rab->proyek,
                                    'rab_pekerjaan' => $rab->pekerjaan,
                                    'mr' => $mrGroup['mr'] ?? '-',
                                    'tanggal' => !empty($mrGroup['tanggal']) && $mrGroup['tanggal'] !== '-' ? $mrGroup['tanggal'] : null,
                                    'supplier' => $material['supplier'] ?? '-',
                                    'item' => $material['item'] ?? '-',
                                    'qty' => $material['qty'] ?? '-',
                                    'satuan' => $material['satuan'] ?? '-',
                                    'harga_satuan' => $material['harga_satuan'] ?? 0,
                                    'sub_total' => $material['sub_total'] ?? 0,
                                    'status' => $material['status'] ?? 'Pengajuan',
                                    'mr_index' => $mrIndex,
                                    'material_index' => $materialIndex,
                                    'created_at' => $rab->created_at,
                                ];
                            }
                        }
                    }
                }
                return $akomodasiData;
            })
            ->flatten(1);

        // Filter berdasarkan status jika ada
        if ($request->filled('status_filter')) {
            $akomodasis = $akomodasis->filter(function ($akomodasi) use ($request) {
                return $akomodasi['status'] === $request->status_filter;
            });
        }

        $akomodasis = $akomodasis->sortByDesc('created_at');

        return view('admin.akomodasi.index', compact('akomodasis'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'akomodasi_index' => 'required|integer',
            'material_index' => 'required|integer',
            'status' => 'required|in:Pengajuan,Disetujui,Ditolak',
        ]);

        try {
            DB::beginTransaction();

            $rab = RancanganAnggaranBiaya::findOrFail($id);
            $akomodasiIndex = $request->akomodasi_index;
            $materialIndex = $request->material_index;

            // Ambil data JSON dan convert ke array
            $akomodasiData = $rab->json_pengeluaran_akomodasi ?? [];
            
            if (isset($akomodasiData[$akomodasiIndex]['materials'][$materialIndex])) {
                // Update status
                $akomodasiData[$akomodasiIndex]['materials'][$materialIndex]['status'] = $request->status;
                
                // Update field JSON dengan data baru
                $rab->json_pengeluaran_akomodasi = $akomodasiData;
                $rab->save();
            }

            DB::commit();

            return redirect()->route('admin.akomodasi.index')
                ->with('success', 'Status material berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
