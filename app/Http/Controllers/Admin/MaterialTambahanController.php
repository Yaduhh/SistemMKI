<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RancanganAnggaranBiaya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaterialTambahanController extends Controller
{
    public function index(Request $request)
    {
        $materialTambahans = RancanganAnggaranBiaya::whereNotNull('json_pengeluaran_material_tambahan')
            ->where('json_pengeluaran_material_tambahan', '!=', '[]')
            ->where('status', '!=', 'selesai')
            ->with('supervisi')
            ->get()
            ->map(function ($rab) {
                $materialTambahanData = [];
                if (isset($rab->json_pengeluaran_material_tambahan) && is_array($rab->json_pengeluaran_material_tambahan)) {
                    foreach ($rab->json_pengeluaran_material_tambahan as $mrIndex => $mrGroup) {
                        if (isset($mrGroup['materials']) && is_array($mrGroup['materials'])) {
                            foreach ($mrGroup['materials'] as $materialIndex => $material) {
                                // Skip data yang semua field-nya null atau kosong
                                if (empty($material['supplier']) && empty($material['item']) && 
                                    empty($material['qty']) && empty($material['satuan']) && 
                                    empty($material['harga_satuan']) && empty($material['sub_total'])) {
                                    continue;
                                }
                                
                                $materialTambahanData[] = [
                                    'rab_id' => $rab->id,
                                    'rab_proyek' => $rab->proyek,
                                    'rab_pekerjaan' => $rab->pekerjaan,
                                    'rab_status' => $rab->status,
                                    'supervisi_id' => $rab->supervisi_id,
                                    'supervisi_nama' => $rab->supervisi ? $rab->supervisi->name : '-',
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
                return $materialTambahanData;
            })
            ->flatten(1);

        // Filter berdasarkan status jika ada
        if ($request->filled('status_filter')) {
            $materialTambahans = $materialTambahans->filter(function ($materialTambahan) use ($request) {
                return $materialTambahan['status'] === $request->status_filter;
            });
        }

        $materialTambahans = $materialTambahans->sortByDesc('tanggal')->values();

        return view('admin.material-tambahan.index', compact('materialTambahans'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'material_tambahan_index' => 'required|integer',
            'material_index' => 'required|integer',
            'status' => 'required|in:Pengajuan,Disetujui,Ditolak',
        ]);

        try {
            DB::beginTransaction();

            $rab = RancanganAnggaranBiaya::findOrFail($id);
            $materialTambahanIndex = $request->material_tambahan_index;
            $materialIndex = $request->material_index;

            // Ambil data JSON dan convert ke array
            $materialTambahanData = $rab->json_pengeluaran_material_tambahan ?? [];
            
            if (isset($materialTambahanData[$materialTambahanIndex]['materials'][$materialIndex])) {
                // Update status
                $materialTambahanData[$materialTambahanIndex]['materials'][$materialIndex]['status'] = $request->status;
                
                // Update field JSON dengan data baru
                $rab->json_pengeluaran_material_tambahan = $materialTambahanData;
                $rab->save();
            }

            DB::commit();

            return redirect()->route('admin.material-tambahan.index')
                ->with('success', 'Status material tambahan berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
