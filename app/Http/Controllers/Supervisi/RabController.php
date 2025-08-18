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
        // Check if the RAB is assigned to this supervisi
        if ($rab->supervisi_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this RAB.');
        }

        $rab->load(['penawaran', 'pemasangan', 'user', 'supervisi']);
        
        return view('supervisi.rab.show', compact('rab'));
    }

    /**
     * Show the form for editing entertainment expenses.
     */
    public function editEntertainment(RancanganAnggaranBiaya $rab)
    {
        // Check if the RAB is assigned to this supervisi
        if ($rab->supervisi_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this RAB.');
        }

        $rab->load(['penawaran', 'pemasangan', 'user', 'supervisi']);
        
        return view('supervisi.entertaiment.edit-entertaiment', compact('rab'));
    }

    /**
     * Update entertainment expenses for the specified RAB.
     */
    public function updateEntertainment(Request $request, RancanganAnggaranBiaya $rab)
    {
        // Check if the RAB is assigned to this supervisi
        if ($rab->supervisi_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this RAB.');
        }

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
}
