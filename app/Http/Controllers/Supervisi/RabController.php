<?php

namespace App\Http\Controllers\Supervisi;

use App\Http\Controllers\Controller;
use App\Models\RancanganAnggaranBiaya;
use Illuminate\Http\Request;

class RabController extends Controller
{
    /**
     * Display a listing of RAB assigned to the supervisi.
     */
    public function index()
    {
        $rabs = RancanganAnggaranBiaya::where('supervisi_id', auth()->id())
            ->with(['penawaran', 'pemasangan', 'user'])
            ->latest()
            ->paginate(10);

        return view('supervisi.rab.index', compact('rabs'));
    }

    /**
     * Display the specified RAB.
     */
    public function show(RancanganAnggaranBiaya $rab)
    {

        $rab->load(['penawaran', 'pemasangan', 'user', 'supervisi']);
        
        return view('supervisi.rab.show', compact('rab'));
    }

    /**
     * Show the form for editing entertainment expenses.
     */
    public function editEntertainment(RancanganAnggaranBiaya $rab)
    {

        $rab->load(['penawaran', 'pemasangan', 'user', 'supervisi']);
        
        return view('supervisi.entertaiment.edit-entertaiment', compact('rab'));
    }

    /**
     * Update entertainment expenses for the specified RAB.
     */
    public function updateEntertainment(Request $request, RancanganAnggaranBiaya $rab)
    {
        $request->validate([
            'json_pengeluaran_entertaiment' => 'nullable|array',
            'json_pengeluaran_entertaiment.*.mr' => 'nullable|string|max:255',
            'json_pengeluaran_entertaiment.*.tanggal' => 'nullable|date',
            'json_pengeluaran_entertaiment.*.materials' => 'nullable|array',
            'json_pengeluaran_entertaiment.*.materials.*.supplier' => 'nullable|string|max:255',
            'json_pengeluaran_entertaiment.*.materials.*.item' => 'nullable|string|max:255',
            'json_pengeluaran_entertaiment.*.materials.*.qty' => 'nullable|numeric|min:0',
            'json_pengeluaran_entertaiment.*.materials.*.satuan' => 'nullable|string|max:255',
            'json_pengeluaran_entertaiment.*.materials.*.harga_satuan' => 'nullable|numeric|min:0',
            'json_pengeluaran_entertaiment.*.materials.*.status' => 'nullable|string|in:Pengajuan,Disetujui,Ditolak',
            'json_pengeluaran_entertaiment.*.materials.*.sub_total' => 'nullable|numeric|min:0',
        ]);

        // Clean and validate entertainment data (same format as admin)
        $entertainmentData = [];
        if ($request->has('json_pengeluaran_entertaiment') && is_array($request->json_pengeluaran_entertaiment) && count($request->json_pengeluaran_entertaiment) > 0) {
            foreach ($request->json_pengeluaran_entertaiment as $mr) {
                $cleanMaterials = [];
                if (isset($mr['materials']) && is_array($mr['materials'])) {
                    foreach ($mr['materials'] as $material) {
                        if (!empty($material['supplier']) || !empty($material['item']) || !empty($material['qty']) || !empty($material['harga_satuan'])) {
                            $cleanMaterials[] = [
                                'supplier' => $material['supplier'] ?? '',
                                'item' => $material['item'] ?? '',
                                'qty' => floatval($material['qty'] ?? 0),
                                'satuan' => $material['satuan'] ?? '',
                                'harga_satuan' => floatval($material['harga_satuan'] ?? 0),
                                'status' => $material['status'] ?? 'Pengajuan',
                                'sub_total' => floatval($material['sub_total'] ?? 0)
                            ];
                        }
                    }
                }
                if (!empty($cleanMaterials)) {
                    $entertainmentData[] = [
                        'mr' => $mr['mr'] ?? '',
                        'tanggal' => $mr['tanggal'] ?? '',
                        'materials' => $cleanMaterials
                    ];
                }
            }
        }

        // Update the RAB
        $rab->update([
            'json_pengeluaran_entertaiment' => $entertainmentData
        ]);

        return redirect()->route('supervisi.rab.show', $rab)->with('success', 'Data pengeluaran entertainment berhasil diperbarui.');
    }

    /**
     * Show the form for editing tukang expenses.
     */
    public function editTukang(RancanganAnggaranBiaya $rab)
    {
        $rab->load(['penawaran', 'pemasangan', 'user', 'supervisi', 'dokumentasi']);
        
        return view('supervisi.tukang.edit-tukang', compact('rab'));
    }

    /**
     * Update tukang expenses for the specified RAB.
     */
    public function updateTukang(Request $request, RancanganAnggaranBiaya $rab)
    {
        $request->validate([
            'json_pengeluaran_tukang' => 'nullable|array',
            'json_pengeluaran_tukang.*.debet' => 'nullable|numeric|min:0',
            'json_pengeluaran_tukang.*.termin' => 'nullable|array',
            'json_pengeluaran_tukang.*.termin.*.tanggal' => 'nullable|date',
            'json_pengeluaran_tukang.*.termin.*.kredit' => 'nullable|numeric|min:0',
            'json_pengeluaran_tukang.*.termin.*.sisa' => 'nullable|numeric|min:0',
            'json_pengeluaran_tukang.*.termin.*.persentase' => 'nullable|string|max:255',
            'json_pengeluaran_tukang.*.termin.*.status' => 'nullable|string|in:Pengajuan,Disetujui,Ditolak',
        ]);

        // Clean and validate tukang data
        $tukangData = [];
        if ($request->has('json_pengeluaran_tukang') && is_array($request->json_pengeluaran_tukang) && count($request->json_pengeluaran_tukang) > 0) {
            foreach ($request->json_pengeluaran_tukang as $section) {
                $cleanTermins = [];
                if (isset($section['termin']) && is_array($section['termin'])) {
                    foreach ($section['termin'] as $termin) {
                        if (!empty($termin['tanggal']) || !empty($termin['kredit']) || !empty($termin['status'])) {
                            $cleanTermins[] = [
                                'tanggal' => $termin['tanggal'] ?? '',
                                'kredit' => floatval($termin['kredit'] ?? 0),
                                'sisa' => floatval($termin['sisa'] ?? 0),
                                'persentase' => $termin['persentase'] ?? '',
                                'status' => $termin['status'] ?? 'Pengajuan'
                            ];
                        }
                    }
                }
                if (!empty($cleanTermins)) {
                    $tukangData[] = [
                        'debet' => floatval($section['debet'] ?? 0),
                        'termin' => $cleanTermins
                    ];
                }
            }
        }

        // Update the RAB
        $rab->update([
            'json_pengeluaran_tukang' => $tukangData
        ]);

        return redirect()->route('supervisi.rab.show', $rab)->with('success', 'Data pengeluaran tukang berhasil diperbarui.');
    }

    /**
     * Show the form for editing kerja tambah expenses.
     */
    public function editKerjaTambah(RancanganAnggaranBiaya $rab)
    {
        $rab->load(['penawaran', 'pemasangan', 'user', 'supervisi']);
        
        return view('supervisi.kerja-tambah.edit-kerja-tambah', compact('rab'));
    }

    /**
     * Update kerja tambah expenses for the specified RAB.
     */
    public function updateKerjaTambah(Request $request, RancanganAnggaranBiaya $rab)
    {
        $request->validate([
            'json_kerja_tambah' => 'nullable|array',
            'json_kerja_tambah.*.debet' => 'nullable|numeric|min:0',
            'json_kerja_tambah.*.termin' => 'nullable|array',
            'json_kerja_tambah.*.termin.*.tanggal' => 'nullable|date',
            'json_kerja_tambah.*.termin.*.kredit' => 'nullable|numeric|min:0',
            'json_kerja_tambah.*.termin.*.sisa' => 'nullable|numeric|min:0',
            'json_kerja_tambah.*.termin.*.persentase' => 'nullable|string|max:255',
            'json_kerja_tambah.*.termin.*.status' => 'nullable|string|in:Pengajuan,Disetujui,Ditolak',
        ]);

        // Clean and validate kerja tambah data
        $kerjaTambahData = [];
        if ($request->has('json_kerja_tambah') && is_array($request->json_kerja_tambah) && count($request->json_kerja_tambah) > 0) {
            foreach ($request->json_kerja_tambah as $section) {
                $cleanTermins = [];
                if (isset($section['termin']) && is_array($section['termin'])) {
                    foreach ($section['termin'] as $termin) {
                        if (!empty($termin['tanggal']) || !empty($termin['kredit']) || !empty($termin['status'])) {
                            $cleanTermins[] = [
                                'tanggal' => $termin['tanggal'] ?? '',
                                'kredit' => floatval($termin['kredit'] ?? 0),
                                'sisa' => floatval($termin['sisa'] ?? 0),
                                'persentase' => $termin['persentase'] ?? '',
                                'status' => $termin['status'] ?? 'Pengajuan'
                            ];
                        }
                    }
                }
                if (!empty($cleanTermins)) {
                    $kerjaTambahData[] = [
                        'debet' => floatval($section['debet'] ?? 0),
                        'termin' => $cleanTermins
                    ];
                }
            }
        }

        // Update the RAB
        $rab->update([
            'json_kerja_tambah' => $kerjaTambahData
        ]);

        return redirect()->route('supervisi.rab.show', $rab)->with('success', 'Data kerja tambah berhasil diperbarui.');
    }

    /**
     * Show the form for editing material tambahan expenses.
     */
    public function editMaterialTambahan(RancanganAnggaranBiaya $rab)
    {
        $rab->load(['penawaran', 'pemasangan', 'user', 'supervisi']);
        
        return view('supervisi.material-tambahan.edit-material-tambahan', compact('rab'));
    }

    /**
     * Update material tambahan expenses for the specified RAB.
     */
    public function updateMaterialTambahan(Request $request, RancanganAnggaranBiaya $rab)
    {
        $request->validate([
            'json_pengeluaran_material_tambahan' => 'nullable|array',
            'json_pengeluaran_material_tambahan.*.mr' => 'nullable|string|max:255',
            'json_pengeluaran_material_tambahan.*.tanggal' => 'nullable|date',
            'json_pengeluaran_material_tambahan.*.materials' => 'nullable|array',
            'json_pengeluaran_material_tambahan.*.materials.*.supplier' => 'nullable|string|max:255',
            'json_pengeluaran_material_tambahan.*.materials.*.item' => 'nullable|string|max:255',
            'json_pengeluaran_material_tambahan.*.materials.*.qty' => 'nullable|numeric|min:0',
            'json_pengeluaran_material_tambahan.*.materials.*.satuan' => 'nullable|string|max:255',
            'json_pengeluaran_material_tambahan.*.materials.*.harga_satuan' => 'nullable|numeric|min:0',
            'json_pengeluaran_material_tambahan.*.materials.*.status' => 'nullable|string|in:Pengajuan,Disetujui,Ditolak',
            'json_pengeluaran_material_tambahan.*.materials.*.sub_total' => 'nullable|numeric|min:0',
        ]);

        // Clean and validate material tambahan data (same format as entertainment)
        $materialTambahanData = [];
        if ($request->has('json_pengeluaran_material_tambahan') && is_array($request->json_pengeluaran_material_tambahan) && count($request->json_pengeluaran_material_tambahan) > 0) {
            foreach ($request->json_pengeluaran_material_tambahan as $mr) {
                $cleanMaterials = [];
                if (isset($mr['materials']) && is_array($mr['materials'])) {
                    foreach ($mr['materials'] as $material) {
                        if (!empty($material['supplier']) || !empty($material['item']) || !empty($material['qty']) || !empty($material['harga_satuan'])) {
                            $cleanMaterials[] = [
                                'supplier' => $material['supplier'] ?? '',
                                'item' => $material['item'] ?? '',
                                'qty' => floatval($material['qty'] ?? 0),
                                'satuan' => $material['satuan'] ?? '',
                                'harga_satuan' => floatval($material['harga_satuan'] ?? 0),
                                'status' => $material['status'] ?? 'Pengajuan',
                                'sub_total' => floatval($material['sub_total'] ?? 0)
                            ];
                        }
                    }
                }
                if (!empty($cleanMaterials)) {
                    $materialTambahanData[] = [
                        'mr' => $mr['mr'] ?? '',
                        'tanggal' => $mr['tanggal'] ?? '',
                        'materials' => $cleanMaterials
                    ];
                }
            }
        }

        // Update the RAB
        $rab->update([
            'json_pengeluaran_material_tambahan' => $materialTambahanData
        ]);

        return redirect()->route('supervisi.rab.show', $rab)->with('success', 'Data pengeluaran material tambahan berhasil diperbarui.');
    }
}
