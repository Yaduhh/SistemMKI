<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RancanganAnggaranBiaya;
use App\Models\Penawaran;
use App\Models\Pemasangan;

class RancanganAnggaranBiayaController extends Controller
{
    public function index()
    {
        $rabs = RancanganAnggaranBiaya::latest()->paginate(20);
        return view('admin.rancangan_anggaran_biaya.index', compact('rabs'));
    }

    public function create(Request $request)
    {
        $penawaran = Penawaran::with('pemasangans')->findOrFail($request->penawaran_id);
        $pemasangan = $penawaran->pemasangans->first();
        $produkPenawaran = [];

        if (is_array($penawaran->json_produk)) {
            foreach ($penawaran->json_produk as $area) {
                $judul = $area['judul'] ?? '';
                if (isset($area['product_sections']) && is_array($area['product_sections'])) {
                    foreach ($area['product_sections'] as $sectionName => $products) {
                        foreach ($products as $product) {
                            $produkPenawaran[] = array_merge(
                                [
                                    'area' => $judul,
                                    'section' => $sectionName,
                                ],
                                $product
                            );
                        }
                    }
                }
            }
        }

        return view('admin.rancangan_anggaran_biaya.create', compact('penawaran', 'pemasangan', 'produkPenawaran'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'proyek' => 'required|string|max:255',
            'pekerjaan' => 'required|string|max:255',
            'kontraktor' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'json_pengeluaran_material_utama' => 'nullable|array',
            'json_pengeluaran_material_pendukung' => 'nullable|array',
            'json_pengeluaran_entertaiment' => 'nullable|array',
            'json_pengeluaran_akomodasi' => 'nullable|array',
            'json_pengeluaran_lainnya' => 'nullable|array',
            'json_pengeluaran_tukang' => 'nullable|array',
            'json_kerja_tambah' => 'nullable|array',
        ]);
        $validated['status_deleted'] = 0;
        $validated['status'] = $request->status ?? null;
        $validated['created_by'] = auth()->id();
        $validated['penawaran_id'] = $request->penawaran_id;
        $validated['pemasangan_id'] = $request->pemasangan_id;
        $rab = RancanganAnggaranBiaya::create($validated);
        return redirect()->route('admin.rancangan-anggaran-biaya.index')->with('success', 'RAB berhasil dibuat.');
    }
}
