<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RancanganAnggaranBiaya;
use App\Models\Penawaran;
use App\Models\Pemasangan;
use App\Models\User;

class RancanganAnggaranBiayaController extends Controller
{
    public function index()
    {
        $query = RancanganAnggaranBiaya::with(['penawaran', 'pemasangan', 'user'])->where('status_deleted', false);

        // Search functionality
        if (request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('proyek', 'like', "%{$search}%")
                  ->orWhere('pekerjaan', 'like', "%{$search}%")
                  ->orWhere('kontraktor', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhereHas('penawaran', function($penawaranQuery) use ($search) {
                      $penawaranQuery->where('nomor_penawaran', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if (request()->has('status') && request('status') !== '') {
            $query->where('status', request('status'));
        }

        // Get filtered and paginated results
        $rabs = $query->latest()->paginate(12);

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
            'material_utama' => 'nullable|array',
            'material_utama.*.item' => 'nullable|string',
            'material_utama.*.type' => 'nullable|string',
            'material_utama.*.dimensi' => 'nullable|string',
            'material_utama.*.panjang' => 'nullable|string',
            'material_utama.*.qty' => 'nullable|numeric',
            'material_utama.*.satuan' => 'required|string',
            'material_utama.*.warna' => 'nullable|string',
            'material_utama.*.harga_satuan' => 'nullable|numeric',
            'material_utama.*.total' => 'nullable|numeric',
            'json_pengeluaran_material_utama' => 'nullable', // allow any type
            'json_pengeluaran_material_pendukung' => 'nullable|array',
            'json_pengeluaran_entertaiment' => 'nullable|array',
            'json_pengeluaran_akomodasi' => 'nullable|array',
            'json_pengeluaran_lainnya' => 'nullable|array',
            'json_pengeluaran_tukang' => 'nullable|array',
            'json_kerja_tambah' => 'nullable|array',
        ]);
        
        // Handle material utama from form inputs
        $materialUtama = [];
        if ($request->has('material_utama') && is_array($request->material_utama)) {
            foreach ($request->material_utama as $item) {
                if (!empty($item['item']) && !empty($item['satuan'])) {
                    $materialUtama[] = [
                        'item' => $item['item'],
                        'type' => $item['type'] ?? '',
                        'dimensi' => $item['dimensi'] ?? '',
                        'panjang' => $item['panjang'] ?? '',
                        'qty' => floatval($item['qty'] ?? 0),
                        'satuan' => $item['satuan'],
                        'warna' => $item['warna'] ?? '',
                        'harga_satuan' => floatval($item['harga_satuan'] ?? 0),
                        'total' => floatval($item['total'] ?? 0)
                    ];
                }
            }
        } elseif ($request->has('json_pengeluaran_material_utama')) {
            // Fallback for JSON string
            if (is_array($request->json_pengeluaran_material_utama)) {
                $materialUtama = $request->json_pengeluaran_material_utama;
            } elseif (is_string($request->json_pengeluaran_material_utama)) {
                $decoded = json_decode($request->json_pengeluaran_material_utama, true);
                if (is_array($decoded)) {
                    $materialUtama = $decoded;
                }
            }
        }
        
        // Clean and validate tukang data (remove empty sections)
        $tukangData = [];
        if ($request->has('json_pengeluaran_tukang') && is_array($request->json_pengeluaran_tukang)) {
            foreach ($request->json_pengeluaran_tukang as $section) {
                if (!empty($section['debet']) && isset($section['termin']) && is_array($section['termin'])) {
                    $cleanTermin = [];
                    foreach ($section['termin'] as $termin) {
                        if (!empty($termin['tanggal']) && !empty($termin['kredit'])) {
                            $cleanTermin[] = [
                                'tanggal' => $termin['tanggal'],
                                'kredit' => $termin['kredit'],
                                'sisa' => $termin['sisa'] ?? 0,
                                'persentase' => $termin['persentase'] ?? '0%'
                            ];
                        }
                    }
                    if (!empty($cleanTermin)) {
                        $tukangData[] = [
                            'debet' => $section['debet'],
                            'termin' => $cleanTermin
                        ];
                    }
                }
            }
        }
        
        // Clean and validate kerja tambah data (remove empty sections)
        $kerjaTambahData = [];
        if ($request->has('json_kerja_tambah') && is_array($request->json_kerja_tambah)) {
            foreach ($request->json_kerja_tambah as $section) {
                if (!empty($section['debet']) && isset($section['termin']) && is_array($section['termin'])) {
                    $cleanTermin = [];
                    foreach ($section['termin'] as $termin) {
                        if (!empty($termin['tanggal']) && !empty($termin['kredit'])) {
                            $cleanTermin[] = [
                                'tanggal' => $termin['tanggal'],
                                'kredit' => $termin['kredit'],
                                'sisa' => $termin['sisa'] ?? 0,
                                'persentase' => $termin['persentase'] ?? '0%'
                            ];
                        }
                    }
                    if (!empty($cleanTermin)) {
                        $kerjaTambahData[] = [
                            'debet' => $section['debet'],
                            'termin' => $cleanTermin
                        ];
                    }
                }
            }
        }
        
        // Clean and validate entertaiment data (remove empty sections)
        $entertaimentData = [];
        if ($request->has('json_pengeluaran_entertaiment') && is_array($request->json_pengeluaran_entertaiment)) {
            foreach ($request->json_pengeluaran_entertaiment as $mr) {
                if (!empty($mr['mr']) && isset($mr['materials']) && is_array($mr['materials'])) {
                    $cleanMaterials = [];
                    foreach ($mr['materials'] as $material) {
                        if (!empty($material['supplier']) || !empty($material['item']) || !empty($material['qty']) || !empty($material['harga_satuan'])) {
                            $cleanMaterials[] = [
                                'supplier' => $material['supplier'] ?? '',
                                'item' => $material['item'] ?? '',
                                'qty' => floatval($material['qty'] ?? 0),
                                'satuan' => $material['satuan'] ?? '',
                                'harga_satuan' => floatval($material['harga_satuan'] ?? 0),
                                'sub_total' => floatval($material['sub_total'] ?? 0)
                            ];
                        }
                    }
                    if (!empty($cleanMaterials)) {
                        $entertaimentData[] = [
                            'mr' => $mr['mr'],
                            'tanggal' => $mr['tanggal'] ?? '',
                            'materials' => $cleanMaterials
                        ];
                    }
                }
            }
        }
        
        // Clean and validate akomodasi data (remove empty sections)
        $akomodasiData = [];
        if ($request->has('json_pengeluaran_akomodasi') && is_array($request->json_pengeluaran_akomodasi)) {
            foreach ($request->json_pengeluaran_akomodasi as $mr) {
                if (!empty($mr['mr']) && isset($mr['materials']) && is_array($mr['materials'])) {
                    $cleanMaterials = [];
                    foreach ($mr['materials'] as $material) {
                        if (!empty($material['supplier']) || !empty($material['item']) || !empty($material['qty']) || !empty($material['harga_satuan'])) {
                            $cleanMaterials[] = [
                                'supplier' => $material['supplier'] ?? '',
                                'item' => $material['item'] ?? '',
                                'qty' => floatval($material['qty'] ?? 0),
                                'satuan' => $material['satuan'] ?? '',
                                'harga_satuan' => floatval($material['harga_satuan'] ?? 0),
                                'sub_total' => floatval($material['sub_total'] ?? 0)
                            ];
                        }
                    }
                    if (!empty($cleanMaterials)) {
                        $akomodasiData[] = [
                            'mr' => $mr['mr'],
                            'tanggal' => $mr['tanggal'] ?? '',
                            'materials' => $cleanMaterials
                        ];
                    }
                }
            }
        }
        
        // Clean and validate lainnya data (remove empty sections)
        $lainnyaData = [];
        if ($request->has('json_pengeluaran_lainnya') && is_array($request->json_pengeluaran_lainnya)) {
            foreach ($request->json_pengeluaran_lainnya as $mr) {
                if (!empty($mr['mr']) && isset($mr['materials']) && is_array($mr['materials'])) {
                    $cleanMaterials = [];
                    foreach ($mr['materials'] as $material) {
                        if (!empty($material['supplier']) || !empty($material['item']) || !empty($material['qty']) || !empty($material['harga_satuan'])) {
                            $cleanMaterials[] = [
                                'supplier' => $material['supplier'] ?? '',
                                'item' => $material['item'] ?? '',
                                'qty' => floatval($material['qty'] ?? 0),
                                'satuan' => $material['satuan'] ?? '',
                                'harga_satuan' => floatval($material['harga_satuan'] ?? 0),
                                'sub_total' => floatval($material['sub_total'] ?? 0)
                            ];
                        }
                    }
                    if (!empty($cleanMaterials)) {
                        $lainnyaData[] = [
                            'mr' => $mr['mr'],
                            'tanggal' => $mr['tanggal'] ?? '',
                            'materials' => $cleanMaterials
                        ];
                    }
                }
            }
        }
        
        // Clean and validate entertaiment data (keep structure with null values)
        $entertaimentData = [];
        if ($request->has('json_pengeluaran_entertaiment') && is_array($request->json_pengeluaran_entertaiment) && count($request->json_pengeluaran_entertaiment) > 0) {
            foreach ($request->json_pengeluaran_entertaiment as $mr) {
                $cleanMaterials = [];
                if (isset($mr['materials']) && is_array($mr['materials'])) {
                    foreach ($mr['materials'] as $material) {
                        $cleanMaterials[] = [
                            'supplier' => $material['supplier'] ?? null,
                            'item' => $material['item'] ?? null,
                            'qty' => !empty($material['qty']) ? floatval($material['qty']) : null,
                            'satuan' => $material['satuan'] ?? null,
                            'harga_satuan' => !empty($material['harga_satuan']) ? floatval($material['harga_satuan']) : null,
                            'sub_total' => !empty($material['sub_total']) ? floatval($material['sub_total']) : null
                        ];
                    }
                }
                $entertaimentData[] = [
                    'mr' => $mr['mr'] ?? null,
                    'tanggal' => $mr['tanggal'] ?? null,
                    'materials' => $cleanMaterials
                ];
            }
        } else {
            $entertaimentData = [[
                'mr' => null,
                'tanggal' => null,
                'materials' => [[
                    'supplier' => null,
                    'item' => null,
                    'qty' => null,
                    'satuan' => null,
                    'harga_satuan' => null,
                    'sub_total' => null
                ]]
            ]];
        }
        
        // Clean and validate akomodasi data (keep structure with null values)
        $akomodasiData = [];
        if ($request->has('json_pengeluaran_akomodasi') && is_array($request->json_pengeluaran_akomodasi) && count($request->json_pengeluaran_akomodasi) > 0) {
            foreach ($request->json_pengeluaran_akomodasi as $mr) {
                $cleanMaterials = [];
                if (isset($mr['materials']) && is_array($mr['materials'])) {
                    foreach ($mr['materials'] as $material) {
                        $cleanMaterials[] = [
                            'supplier' => $material['supplier'] ?? null,
                            'item' => $material['item'] ?? null,
                            'qty' => !empty($material['qty']) ? floatval($material['qty']) : null,
                            'satuan' => $material['satuan'] ?? null,
                            'harga_satuan' => !empty($material['harga_satuan']) ? floatval($material['harga_satuan']) : null,
                            'sub_total' => !empty($material['sub_total']) ? floatval($material['sub_total']) : null
                        ];
                    }
                }
                $akomodasiData[] = [
                    'mr' => $mr['mr'] ?? null,
                    'tanggal' => $mr['tanggal'] ?? null,
                    'materials' => $cleanMaterials
                ];
            }
        } else {
            $akomodasiData = [[
                'mr' => null,
                'tanggal' => null,
                'materials' => [[
                    'supplier' => null,
                    'item' => null,
                    'qty' => null,
                    'satuan' => null,
                    'harga_satuan' => null,
                    'sub_total' => null
                ]]
            ]];
        }
        
        // Clean and validate lainnya data (keep structure with null values)
        $lainnyaData = [];
        if ($request->has('json_pengeluaran_lainnya') && is_array($request->json_pengeluaran_lainnya) && count($request->json_pengeluaran_lainnya) > 0) {
            foreach ($request->json_pengeluaran_lainnya as $mr) {
                $cleanMaterials = [];
                if (isset($mr['materials']) && is_array($mr['materials'])) {
                    foreach ($mr['materials'] as $material) {
                        $cleanMaterials[] = [
                            'supplier' => $material['supplier'] ?? null,
                            'item' => $material['item'] ?? null,
                            'qty' => !empty($material['qty']) ? floatval($material['qty']) : null,
                            'satuan' => $material['satuan'] ?? null,
                            'harga_satuan' => !empty($material['harga_satuan']) ? floatval($material['harga_satuan']) : null,
                            'sub_total' => !empty($material['sub_total']) ? floatval($material['sub_total']) : null
                        ];
                    }
                }
                $lainnyaData[] = [
                    'mr' => $mr['mr'] ?? null,
                    'tanggal' => $mr['tanggal'] ?? null,
                    'materials' => $cleanMaterials
                ];
            }
        } else {
            $lainnyaData = [[
                'mr' => null,
                'tanggal' => null,
                'materials' => [[
                    'supplier' => null,
                    'item' => null,
                    'qty' => null,
                    'satuan' => null,
                    'harga_satuan' => null,
                    'sub_total' => null
                ]]
            ]];
        }
        
        $validated['json_pengeluaran_material_utama'] = $materialUtama;
        $validated['json_pengeluaran_material_pendukung'] = $request->json_pengeluaran_material_pendukung ?? [];
        $validated['json_pengeluaran_entertaiment'] = $entertaimentData;
        $validated['json_pengeluaran_akomodasi'] = $akomodasiData;
        $validated['json_pengeluaran_lainnya'] = $lainnyaData;
        $validated['json_pengeluaran_tukang'] = $tukangData;
        $validated['json_kerja_tambah'] = $kerjaTambahData;
        $validated['status_deleted'] = false;
        $validated['status'] = $request->status ?? 'draft';
        $validated['created_by'] = auth()->id();
        $validated['penawaran_id'] = $request->penawaran_id ?? null;
        $validated['pemasangan_id'] = $request->pemasangan_id ?? null;
        
        $rab = RancanganAnggaranBiaya::create($validated);
        return redirect()->route('admin.rancangan-anggaran-biaya.index')->with('success', 'RAB berhasil dibuat.');
    }

    public function show(RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        $rancanganAnggaranBiaya->load(['penawaran', 'pemasangan', 'user']);
        return view('admin.rancangan_anggaran_biaya.show', compact('rancanganAnggaranBiaya'));
    }

    public function edit(RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        $rancanganAnggaranBiaya->load(['penawaran', 'pemasangan']);
        $penawaran = $rancanganAnggaranBiaya->penawaran;
        $pemasangan = $rancanganAnggaranBiaya->pemasangan;
        $produkPenawaran = [];

        if ($penawaran && is_array($penawaran->json_produk)) {
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

        // Clean old data format for tukang and kerja tambah
        $rancanganAnggaranBiaya->json_pengeluaran_tukang = $this->cleanOldDataFormat($rancanganAnggaranBiaya->json_pengeluaran_tukang);
        $rancanganAnggaranBiaya->json_kerja_tambah = $this->cleanOldDataFormat($rancanganAnggaranBiaya->json_kerja_tambah);

        return view('admin.rancangan_anggaran_biaya.edit', compact('rancanganAnggaranBiaya', 'penawaran', 'pemasangan', 'produkPenawaran'));
    }

    public function update(Request $request, RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        $validated = $request->validate([
            'proyek' => 'required|string|max:255',
            'pekerjaan' => 'required|string|max:255',
            'kontraktor' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'material_utama' => 'nullable|array',
            'material_utama.*.item' => 'nullable|string',
            'material_utama.*.type' => 'nullable|string',
            'material_utama.*.dimensi' => 'nullable|string',
            'material_utama.*.panjang' => 'nullable|string',
            'material_utama.*.qty' => 'nullable|numeric',
            'material_utama.*.satuan' => 'required|string',
            'material_utama.*.warna' => 'nullable|string',
            'material_utama.*.harga_satuan' => 'nullable|numeric',
            'material_utama.*.total' => 'nullable|numeric',
            'json_pengeluaran_material_utama' => 'nullable', // allow any type
            'json_pengeluaran_material_pendukung' => 'nullable|array',
            'json_pengeluaran_entertaiment' => 'nullable|array',
            'json_pengeluaran_akomodasi' => 'nullable|array',
            'json_pengeluaran_lainnya' => 'nullable|array',
            'json_pengeluaran_tukang' => 'nullable|array',
            'json_kerja_tambah' => 'nullable|array',
        ]);
        
        // Handle material utama from form inputs
        $materialUtama = [];
        if ($request->has('material_utama') && is_array($request->material_utama)) {
            foreach ($request->material_utama as $item) {
                if (!empty($item['item']) && !empty($item['satuan'])) {
                    $materialUtama[] = [
                        'item' => $item['item'],
                        'type' => $item['type'] ?? '',
                        'dimensi' => $item['dimensi'] ?? '',
                        'panjang' => $item['panjang'] ?? '',
                        'qty' => floatval($item['qty'] ?? 0),
                        'satuan' => $item['satuan'],
                        'warna' => $item['warna'] ?? '',
                        'harga_satuan' => floatval($item['harga_satuan'] ?? 0),
                        'total' => floatval($item['total'] ?? 0)
                    ];
                }
            }
        } elseif ($request->has('json_pengeluaran_material_utama')) {
            // Fallback for JSON string
            if (is_array($request->json_pengeluaran_material_utama)) {
                $materialUtama = $request->json_pengeluaran_material_utama;
            } elseif (is_string($request->json_pengeluaran_material_utama)) {
                $decoded = json_decode($request->json_pengeluaran_material_utama, true);
                if (is_array($decoded)) {
                    $materialUtama = $decoded;
                }
            }
        }
        
        // Clean and validate tukang data (remove empty sections)
        $tukangData = [];
        if ($request->has('json_pengeluaran_tukang') && is_array($request->json_pengeluaran_tukang)) {
            foreach ($request->json_pengeluaran_tukang as $section) {
                if (!empty($section['debet']) && isset($section['termin']) && is_array($section['termin'])) {
                    $cleanTermin = [];
                    foreach ($section['termin'] as $termin) {
                        if (!empty($termin['tanggal']) && !empty($termin['kredit'])) {
                            $cleanTermin[] = [
                                'tanggal' => $termin['tanggal'],
                                'kredit' => $termin['kredit'],
                                'sisa' => $termin['sisa'] ?? 0,
                                'persentase' => $termin['persentase'] ?? '0%'
                            ];
                        }
                    }
                    if (!empty($cleanTermin)) {
                        $tukangData[] = [
                            'debet' => $section['debet'],
                            'termin' => $cleanTermin
                        ];
                    }
                }
            }
        }
        
        // Clean and validate kerja tambah data (remove empty sections)
        $kerjaTambahData = [];
        if ($request->has('json_kerja_tambah') && is_array($request->json_kerja_tambah)) {
            foreach ($request->json_kerja_tambah as $section) {
                if (!empty($section['debet']) && isset($section['termin']) && is_array($section['termin'])) {
                    $cleanTermin = [];
                    foreach ($section['termin'] as $termin) {
                        if (!empty($termin['tanggal']) && !empty($termin['kredit'])) {
                            $cleanTermin[] = [
                                'tanggal' => $termin['tanggal'],
                                'kredit' => $termin['kredit'],
                                'sisa' => $termin['sisa'] ?? 0,
                                'persentase' => $termin['persentase'] ?? '0%'
                            ];
                        }
                    }
                    if (!empty($cleanTermin)) {
                        $kerjaTambahData[] = [
                            'debet' => $section['debet'],
                            'termin' => $cleanTermin
                        ];
                    }
                }
            }
        }
        
        // Clean and validate entertaiment data (remove empty sections)
        $entertaimentData = [];
        if ($request->has('json_pengeluaran_entertaiment') && is_array($request->json_pengeluaran_entertaiment)) {
            foreach ($request->json_pengeluaran_entertaiment as $mr) {
                if (!empty($mr['mr']) && isset($mr['materials']) && is_array($mr['materials'])) {
                    $cleanMaterials = [];
                    foreach ($mr['materials'] as $material) {
                        if (!empty($material['supplier']) || !empty($material['item']) || !empty($material['qty']) || !empty($material['harga_satuan'])) {
                            $cleanMaterials[] = [
                                'supplier' => $material['supplier'] ?? '',
                                'item' => $material['item'] ?? '',
                                'qty' => floatval($material['qty'] ?? 0),
                                'satuan' => $material['satuan'] ?? '',
                                'harga_satuan' => floatval($material['harga_satuan'] ?? 0),
                                'sub_total' => floatval($material['sub_total'] ?? 0)
                            ];
                        }
                    }
                    if (!empty($cleanMaterials)) {
                        $entertaimentData[] = [
                            'mr' => $mr['mr'],
                            'tanggal' => $mr['tanggal'] ?? '',
                            'materials' => $cleanMaterials
                        ];
                    }
                }
            }
        }
        
        // Clean and validate akomodasi data (remove empty sections)
        $akomodasiData = [];
        if ($request->has('json_pengeluaran_akomodasi') && is_array($request->json_pengeluaran_akomodasi)) {
            foreach ($request->json_pengeluaran_akomodasi as $mr) {
                if (!empty($mr['mr']) && isset($mr['materials']) && is_array($mr['materials'])) {
                    $cleanMaterials = [];
                    foreach ($mr['materials'] as $material) {
                        if (!empty($material['supplier']) || !empty($material['item']) || !empty($material['qty']) || !empty($material['harga_satuan'])) {
                            $cleanMaterials[] = [
                                'supplier' => $material['supplier'] ?? '',
                                'item' => $material['item'] ?? '',
                                'qty' => floatval($material['qty'] ?? 0),
                                'satuan' => $material['satuan'] ?? '',
                                'harga_satuan' => floatval($material['harga_satuan'] ?? 0),
                                'sub_total' => floatval($material['sub_total'] ?? 0)
                            ];
                        }
                    }
                    if (!empty($cleanMaterials)) {
                        $akomodasiData[] = [
                            'mr' => $mr['mr'],
                            'tanggal' => $mr['tanggal'] ?? '',
                            'materials' => $cleanMaterials
                        ];
                    }
                }
            }
        }
        
        // Clean and validate lainnya data (remove empty sections)
        $lainnyaData = [];
        if ($request->has('json_pengeluaran_lainnya') && is_array($request->json_pengeluaran_lainnya)) {
            foreach ($request->json_pengeluaran_lainnya as $mr) {
                if (!empty($mr['mr']) && isset($mr['materials']) && is_array($mr['materials'])) {
                    $cleanMaterials = [];
                    foreach ($mr['materials'] as $material) {
                        if (!empty($material['supplier']) || !empty($material['item']) || !empty($material['qty']) || !empty($material['harga_satuan'])) {
                            $cleanMaterials[] = [
                                'supplier' => $material['supplier'] ?? '',
                                'item' => $material['item'] ?? '',
                                'qty' => floatval($material['qty'] ?? 0),
                                'satuan' => $material['satuan'] ?? '',
                                'harga_satuan' => floatval($material['harga_satuan'] ?? 0),
                                'sub_total' => floatval($material['sub_total'] ?? 0)
                            ];
                        }
                    }
                    if (!empty($cleanMaterials)) {
                        $lainnyaData[] = [
                            'mr' => $mr['mr'],
                            'tanggal' => $mr['tanggal'] ?? '',
                            'materials' => $cleanMaterials
                        ];
                    }
                }
            }
        }
        
        $validated['json_pengeluaran_material_utama'] = $materialUtama;
        $validated['json_pengeluaran_material_pendukung'] = $request->json_pengeluaran_material_pendukung ?? [];
        $validated['json_pengeluaran_entertaiment'] = $entertaimentData;
        $validated['json_pengeluaran_akomodasi'] = $akomodasiData;
        $validated['json_pengeluaran_lainnya'] = $lainnyaData;
        $validated['json_pengeluaran_tukang'] = $tukangData;
        $validated['json_kerja_tambah'] = $kerjaTambahData;
        $rancanganAnggaranBiaya->update($validated);
        return redirect()->route('admin.rancangan-anggaran-biaya.index')->with('success', 'RAB berhasil diupdate.');
    }

    public function destroy(RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        $rancanganAnggaranBiaya->update(['status_deleted' => true]);
        return redirect()->route('admin.rancangan-anggaran-biaya.index')->with('success', 'RAB berhasil dihapus.');
    }

    public function updateStatus(Request $request, RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        $request->validate([
            'status' => 'required|in:draft,approved,rejected'
        ]);

        $status = $request->status;
        $statusText = '';
        
        switch ($status) {
            case 'draft':
                $statusText = 'Draft';
                break;
            case 'approved':
                $statusText = 'Disetujui';
                break;
            case 'rejected':
                $statusText = 'Ditolak';
                break;
        }

        $rancanganAnggaranBiaya->update(['status' => $status]);
        
        return redirect()->route('admin.rancangan-anggaran-biaya.show', $rancanganAnggaranBiaya)->with('success', "Status RAB berhasil diubah menjadi {$statusText}.");
    }

    /**
     * Clean and convert old data format to new format
     */
    private function cleanOldDataFormat($data)
    {
        if (!is_array($data)) {
            return [];
        }

        $cleanedData = [];
        foreach ($data as $section) {
            if (isset($section['debet']) && isset($section['termin']) && is_array($section['termin'])) {
                $cleanTermin = [];
                foreach ($section['termin'] as $termin) {
                    if (!empty($termin['tanggal']) && isset($termin['kredit'])) {
                        $cleanTermin[] = [
                            'tanggal' => $termin['tanggal'],
                            'kredit' => $termin['kredit'],
                            'sisa' => $termin['sisa'] ?? 0,
                            'persentase' => $termin['persentase'] ?? '0%'
                        ];
                    }
                }
                if (!empty($cleanTermin)) {
                    $cleanedData[] = [
                        'debet' => $section['debet'],
                        'termin' => $cleanTermin
                    ];
                }
            }
        }
        return $cleanedData;
    }
}
