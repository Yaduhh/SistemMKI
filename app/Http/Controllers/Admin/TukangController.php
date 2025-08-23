<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RancanganAnggaranBiaya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TukangController extends Controller
{
    public function index(Request $request)
    {
        $tukangs = RancanganAnggaranBiaya::whereNotNull('json_pengeluaran_tukang')
            ->where('json_pengeluaran_tukang', '!=', '[]')
            ->with('supervisi')
            ->get()
            ->map(function ($rab) {
                $tukangData = [];
                if (isset($rab->json_pengeluaran_tukang) && is_array($rab->json_pengeluaran_tukang)) {
                    foreach ($rab->json_pengeluaran_tukang as $sectionIndex => $section) {
                        if (isset($section['termin']) && is_array($section['termin'])) {
                            foreach ($section['termin'] as $terminIndex => $termin) {
                                // Skip data yang semua field-nya null atau kosong
                                if (empty($termin['tanggal']) && empty($termin['kredit']) && 
                                    empty($termin['sisa']) && empty($termin['persentase'])) {
                                    continue;
                                }
                                
                                $tukangData[] = [
                                    'rab_id' => $rab->id,
                                    'rab_proyek' => $rab->proyek,
                                    'rab_pekerjaan' => $rab->pekerjaan,
                                    'rab_status' => $rab->status,
                                    'supervisi_id' => $rab->supervisi_id,
                                    'supervisi_nama' => $rab->supervisi ? $rab->supervisi->name : '-',
                                    'debet' => $section['debet'] ?? 0,
                                    'tanggal' => !empty($termin['tanggal']) ? $termin['tanggal'] : null,
                                    'kredit' => $termin['kredit'] ?? 0,
                                    'sisa' => $termin['sisa'] ?? 0,
                                    'persentase' => $termin['persentase'] ?? '0%',
                                    'status' => $termin['status'] ?? 'Pengajuan',
                                    'section_index' => $sectionIndex,
                                    'termin_index' => $terminIndex,
                                    'created_at' => $rab->created_at,
                                ];
                            }
                        }
                    }
                }
                return $tukangData;
            })
            ->flatten(1);

        // Filter berdasarkan status jika ada
        if ($request->filled('status_filter')) {
            $tukangs = $tukangs->filter(function ($tukang) use ($request) {
                return $tukang['status'] === $request->status_filter;
            });
        }

        $tukangs = $tukangs->sortByDesc('tanggal')->values();

        return view('admin.tukang.index', compact('tukangs'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'section_index' => 'required|integer',
            'termin_index' => 'required|integer',
            'status' => 'required|in:Pengajuan,Disetujui,Ditolak',
        ]);

        try {
            DB::beginTransaction();

            $rab = RancanganAnggaranBiaya::findOrFail($id);
            $sectionIndex = $request->section_index;
            $terminIndex = $request->termin_index;

            // Ambil data JSON dan convert ke array
            $tukangData = $rab->json_pengeluaran_tukang ?? [];
            
            if (isset($tukangData[$sectionIndex]['termin'][$terminIndex])) {
                // Update status
                $tukangData[$sectionIndex]['termin'][$terminIndex]['status'] = $request->status;
                
                // Update field JSON dengan data baru
                $rab->json_pengeluaran_tukang = $tukangData;
                $rab->save();
            }

            DB::commit();

            return redirect()->route('admin.tukang.index')
                ->with('success', 'Status termin tukang berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
