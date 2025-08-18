<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RancanganAnggaranBiaya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntertainmentController extends Controller
{
    public function index(Request $request)
    {
        $entertainments = RancanganAnggaranBiaya::whereNotNull('json_pengeluaran_entertaiment')
            ->where('json_pengeluaran_entertaiment', '!=', '[]')
            ->get()
            ->map(function ($rab) {
                $entertainmentData = [];
                if (isset($rab->json_pengeluaran_entertaiment) && is_array($rab->json_pengeluaran_entertaiment)) {
                    foreach ($rab->json_pengeluaran_entertaiment as $mrIndex => $mrGroup) {
                        if (isset($mrGroup['materials']) && is_array($mrGroup['materials'])) {
                            foreach ($mrGroup['materials'] as $materialIndex => $material) {
                                // Skip data yang semua field-nya null atau kosong
                                if (empty($material['supplier']) && empty($material['item']) && 
                                    empty($material['qty']) && empty($material['satuan']) && 
                                    empty($material['harga_satuan']) && empty($material['sub_total'])) {
                                    continue;
                                }
                                
                                $entertainmentData[] = [
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
                return $entertainmentData;
            })
            ->flatten(1);

        // Filter berdasarkan status jika ada
        if ($request->filled('status_filter')) {
            $entertainments = $entertainments->filter(function ($entertainment) use ($request) {
                return $entertainment['status'] === $request->status_filter;
            });
        }

        $entertainments = $entertainments->sortByDesc('created_at');

        return view('admin.entertainment.index', compact('entertainments'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'entertainment_index' => 'required|integer',
            'material_index' => 'required|integer',
            'status' => 'required|in:Pengajuan,Disetujui,Ditolak',
        ]);

        try {
            DB::beginTransaction();

            $rab = RancanganAnggaranBiaya::findOrFail($id);
            $entertainmentIndex = $request->entertainment_index;
            $materialIndex = $request->material_index;

            // Ambil data JSON dan convert ke array
            $entertainmentData = $rab->json_pengeluaran_entertaiment ?? [];
            
            if (isset($entertainmentData[$entertainmentIndex]['materials'][$materialIndex])) {
                // Update status
                $entertainmentData[$entertainmentIndex]['materials'][$materialIndex]['status'] = $request->status;
                
                // Update field JSON dengan data baru
                $rab->json_pengeluaran_entertaiment = $entertainmentData;
                $rab->save();
            }

            DB::commit();

            return redirect()->route('admin.entertainment.index')
                ->with('success', 'Status material berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
} 