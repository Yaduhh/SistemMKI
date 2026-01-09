<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RancanganAnggaranBiaya;
use App\Models\Penawaran;
use App\Models\Pemasangan;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class RancanganAnggaranBiayaController extends Controller
{
    /**
     * Convert string with format Rupiah to numeric value
     */
    private function convertToNumeric($value)
    {
        if (is_numeric($value)) {
            return $value;
        }
        
        if (is_string($value)) {
            // Remove all non-numeric characters except decimal point
            $numericValue = preg_replace('/[^\d.]/', '', $value);
            return is_numeric($numericValue) ? $numericValue : 0;
        }
        
        return 0;
    }

    /**
     * Convert tukang data to numeric format
     */
    private function convertTukangDataToNumeric($tukangData)
    {
        $convertedData = [];
        foreach ($tukangData as $section) {
            $convertedTermin = [];
            foreach ($section['termin'] as $termin) {
                $convertedTermin[] = [
                    'tanggal' => $termin['tanggal'],
                    'kredit' => $this->convertToNumeric($termin['kredit']),
                    'sisa' => $this->convertToNumeric($termin['sisa']),
                    'persentase' => $termin['persentase'],
                    'status' => $termin['status'] ?? 'Pengajuan'
                ];
            }
            $convertedData[] = [
                'debet' => $this->convertToNumeric($section['debet']),
                'termin' => $convertedTermin
            ];
        }
        return $convertedData;
    }

    /**
     * Convert kerja tambah data to numeric format
     */
    private function convertKerjaTambahDataToNumeric($kerjaTambahData)
    {
        $convertedData = [];
        foreach ($kerjaTambahData as $section) {
            $convertedTermin = [];
            foreach ($section['termin'] as $termin) {
                $convertedTermin[] = [
                    'tanggal' => $termin['tanggal'],
                    'kredit' => $this->convertToNumeric($termin['kredit']),
                    'sisa' => $this->convertToNumeric($termin['sisa']),
                    'persentase' => $termin['persentase'],
                    'status' => $termin['status'] ?? 'Pengajuan'
                ];
            }
            $convertedData[] = [
                'debet' => $this->convertToNumeric($section['debet']),
                'termin' => $convertedTermin
            ];
        }
        return $convertedData;
    }
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
        if (request('status') && request('status') !== '') {
            $query->where('status', request('status'));
        }

        // Get filtered and paginated results
        $rabs = $query->latest()->paginate(12);

        // Debug: Log the query and results
        \Log::info('RAB Filter Debug', [
            'status_filter' => request('status'),
            'search_filter' => request('search'),
            'total_results' => $rabs->total(),
            'current_page' => $rabs->currentPage(),
            'per_page' => $rabs->perPage(),
        ]);

        return view('admin.rancangan_anggaran_biaya.index', compact('rabs'));
    }

    public function create(Request $request)
    {
        $penawaran = Penawaran::with('pemasangans')->findOrFail($request->penawaran_id);
        $pemasangan = $penawaran->pemasangans->first();
        $produkPenawaran = [];

        // Ambil semua pemasangan yang terhubung dengan penawaran ini
        $semuaPemasangan = $penawaran->pemasangans;
        
        // Ambil semua RAB yang sudah ada untuk penawaran ini
        $rabsExisting = RancanganAnggaranBiaya::where('penawaran_id', $penawaran->id)
            ->where('status_deleted', false)
            ->get();
        
        // Filter pemasangan yang belum digunakan (belum ada di RAB)
        $pemasanganTerpakai = $rabsExisting->pluck('pemasangan_id')->filter()->toArray();
        $pemasanganSisa = $semuaPemasangan->whereNotIn('id', $pemasanganTerpakai);

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

        // Tambahkan additional_condition ke produkPenawaran
        if ($penawaran->additional_condition) {
            $additionalConditions = is_string($penawaran->additional_condition) 
                ? json_decode($penawaran->additional_condition, true) 
                : $penawaran->additional_condition;
            
            if (is_array($additionalConditions)) {
                foreach ($additionalConditions as $condition) {
                    $label = $condition['label'] ?? 'Additional Condition';
                    if (isset($condition['produk']) && is_array($condition['produk'])) {
                        foreach ($condition['produk'] as $produk) {
                            $produkPenawaran[] = [
                                'area' => $label,
                                'section' => 'additional_condition',
                                'item' => $produk['nama_produk'] ?? $produk['item'] ?? '',
                                'type' => $produk['code'] ?? '',
                                'dimensi' => '',
                                'panjang' => '',
                                'qty' => $produk['qty'] ?? 0,
                                'satuan' => $produk['satuan'] ?? '',
                                'harga' => $produk['harga'] ?? 0,
                                'total_harga' => $produk['total_harga'] ?? 0,
                            ];
                        }
                    }
                }
            }
        }

        return view('admin.rancangan_anggaran_biaya.create', compact('penawaran', 'pemasangan', 'produkPenawaran', 'pemasanganSisa'));
    }


    public function store(Request $request)
    {
        // Debug: Log request data
        \Log::info('RAB Store - Request data:', [
            'json_pengeluaran_pemasangan' => $request->json_pengeluaran_pemasangan,
            'json_pengeluaran_pemasangan_type' => gettype($request->json_pengeluaran_pemasangan),
            'penawaran_id' => $request->penawaran_id,
            'pemasangan_id' => $request->pemasangan_id
        ]);
        
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
            'json_section_material_pendukung' => 'nullable',
            'json_pengeluaran_material_tambahan' => 'nullable|array',
            'json_pengeluaran_pemasangan' => 'nullable',
            'json_pengajuan_harga_tukang' => 'nullable',
        ]);
        
        // Handle material utama - check if this is a pintu penawaran first
        $materialUtama = [];
        
        // Get penawaran data to check if it's a pintu penawaran
        $penawaran = Penawaran::find($request->penawaran_id);
        
        if ($penawaran && !empty($penawaran->json_penawaran_pintu)) {
            // This is a pintu penawaran - automatically copy from json_penawaran_pintu
            $materialUtama = $penawaran->json_penawaran_pintu;
        } else {
            // This is a regular penawaran - handle from form inputs
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
        }
        
        // Clean and validate tukang data (remove empty sections)
        // Handle json_pengeluaran_tukang - bisa berupa array atau JSON string
        $tukangDataRaw = $request->json_pengeluaran_tukang ?? [];
        if (is_string($tukangDataRaw)) {
            $tukangDataRaw = json_decode($tukangDataRaw, true) ?? [];
        }
        
        if (is_array($tukangDataRaw) && !empty($tukangDataRaw)) {
            $tukangData = $this->convertTukangDataToNumeric($tukangDataRaw);
        } else {
            $tukangData = [];
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
                                'persentase' => $termin['persentase'] ?? '0%',
                                'status' => $termin['status'] ?? 'Pengajuan'
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
        
        // Clean and validate entertaiment data
        // Handle json_pengeluaran_entertaiment - bisa berupa array atau JSON string
        $entertaimentDataRaw = $request->json_pengeluaran_entertaiment ?? [];
        if (is_string($entertaimentDataRaw)) {
            $entertaimentDataRaw = json_decode($entertaimentDataRaw, true) ?? [];
        }
        
        $entertaimentData = [];
        if (is_array($entertaimentDataRaw) && !empty($entertaimentDataRaw)) {
            foreach ($entertaimentDataRaw as $mr) {
                if (!isset($mr) || !is_array($mr)) continue;
                
                $cleanMaterials = [];
                if (isset($mr['materials']) && is_array($mr['materials']) && !empty($mr['materials'])) {
                    foreach ($mr['materials'] as $material) {
                        if (!isset($material) || !is_array($material)) continue;
                        
                        // Only add material if it has at least supplier, item, or harga_satuan
                        $supplier = $material['supplier'] ?? null;
                        $item = $material['item'] ?? null;
                        $hargaSatuan = !empty($material['harga_satuan']) ? floatval($material['harga_satuan']) : null;
                        
                        if ($supplier || $item || ($hargaSatuan && $hargaSatuan > 0)) {
                            $cleanMaterials[] = [
                                'supplier' => $supplier,
                                'item' => $item,
                                'qty' => !empty($material['qty']) ? floatval($material['qty']) : null,
                                'satuan' => $material['satuan'] ?? null,
                                'harga_satuan' => $hargaSatuan,
                                'sub_total' => !empty($material['sub_total']) ? floatval($material['sub_total']) : null,
                                'status' => $material['status'] ?? 'Disetujui'
                            ];
                        }
                    }
                }
                
                // Only add MR group if it has MR or materials
                $mrValue = $mr['mr'] ?? null;
                if ($mrValue || !empty($cleanMaterials)) {
                    $entertaimentData[] = [
                        'mr' => $mrValue,
                        'tanggal' => $mr['tanggal'] ?? null,
                        'materials' => $cleanMaterials
                    ];
                }
            }
        }
        
        // If no data, set to empty array [] (not null or structure with null values)
        if (empty($entertaimentData)) {
            $entertaimentData = [];
        }
        

        
        $validated['json_pengeluaran_material_utama'] = $materialUtama;
        $validated['json_pengeluaran_material_pendukung'] = $request->json_pengeluaran_material_pendukung ?? [];
        $validated['json_pengeluaran_material_tambahan'] = $request->json_pengeluaran_material_tambahan ?? [];
        
        // Handle json_pengeluaran_pemasangan - convert string to array if needed
        $pemasanganData = $request->json_pengeluaran_pemasangan ?? [];
        if (is_string($pemasanganData)) {
            $pemasanganData = json_decode($pemasanganData, true) ?? [];
        }
        $validated['json_pengeluaran_pemasangan'] = $pemasanganData;
        
        // Handle json_pengajuan_harga_tukang - convert string to array if needed
        $hargaTukangData = $request->json_pengajuan_harga_tukang ?? [];
        if (is_string($hargaTukangData)) {
            $hargaTukangData = json_decode($hargaTukangData, true) ?? [];
        }
        $validated['json_pengajuan_harga_tukang'] = $hargaTukangData;
        
        // Handle json_section_material_pendukung - convert string to array if needed
        $sectionMaterialPendukungData = $request->json_section_material_pendukung ?? [];
        if (is_string($sectionMaterialPendukungData)) {
            $sectionMaterialPendukungData = json_decode($sectionMaterialPendukungData, true) ?? [];
        }
        $validated['json_section_material_pendukung'] = $sectionMaterialPendukungData;
        
        // Debug: Log pemasangan data
        \Log::info('RAB Store Debug - Pemasangan Data', [
            'json_pengeluaran_pemasangan' => $request->json_pengeluaran_pemasangan,
            'validated_pemasangan' => $validated['json_pengeluaran_pemasangan']
        ]);
        
        // Set default values for fields that are not used in edit mode
        $validated['json_pengeluaran_entertaiment'] = [];
        $validated['json_pengeluaran_tukang'] = [];
        $validated['json_kerja_tambah'] = [];
        $validated['status_deleted'] = false;
        $validated['status'] = $request->status ?? 'draft';
        $validated['created_by'] = auth()->id();
        $validated['penawaran_id'] = $request->penawaran_id ?? null;
        $validated['pemasangan_id'] = $request->pemasangan_id ?? null;
        $validated['penawaran_pintu'] = ($penawaran && !empty($penawaran->json_penawaran_pintu)) ? 1 : 0;
        
        try {
            // Debug: Log data before create
            \Log::info('RAB Store - Data before create:', [
                'json_pengeluaran_pemasangan' => $validated['json_pengeluaran_pemasangan'],
                'penawaran_id' => $validated['penawaran_id'],
                'pemasangan_id' => $validated['pemasangan_id']
            ]);
            
            $rab = RancanganAnggaranBiaya::create($validated);
            
            // Debug: Check if pemasangan data was saved
            $pemasanganData = $rab->json_pengeluaran_pemasangan;
            $message = 'RAB berhasil dibuat.';
            if (!empty($pemasanganData)) {
                $message .= ' Data pemasangan tersimpan: ' . count($pemasanganData) . ' item.';
            } else {
                $message .= ' WARNING: Data pemasangan kosong!';
            }
            
            \Log::info('RAB Store - Success:', ['message' => $message]);
            return redirect()->route('admin.rancangan-anggaran-biaya.index')->with('success', $message);
        } catch (\Exception $e) {
            \Log::error('RAB Store Error: ' . $e->getMessage());
            \Log::error('RAB Store Error Stack: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function show(RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        $rancanganAnggaranBiaya->load(['penawaran', 'pemasangan', 'user', 'supervisi']);
        return view('admin.rancangan_anggaran_biaya.show', compact('rancanganAnggaranBiaya'));
    }

    public function edit(RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        $penawaran = Penawaran::with('pemasangans')->findOrFail($rancanganAnggaranBiaya->penawaran_id);
        $pemasangan = $penawaran->pemasangans->first();
        $produkPenawaran = [];

        // Ambil semua pemasangan yang terhubung dengan penawaran ini
        $semuaPemasangan = $penawaran->pemasangans;
        
        // Ambil semua RAB yang sudah ada untuk penawaran ini
        $rabsExisting = RancanganAnggaranBiaya::where('penawaran_id', $penawaran->id)
            ->where('status_deleted', false)
            ->get();
        
        // Filter pemasangan yang belum digunakan (belum ada di RAB)
        $pemasanganTerpakai = $rabsExisting->pluck('pemasangan_id')->filter()->toArray();
        $pemasanganSisa = $semuaPemasangan->whereNotIn('id', $pemasanganTerpakai);

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

        // Tambahkan additional_condition ke produkPenawaran
        if ($penawaran->additional_condition) {
            $additionalConditions = is_string($penawaran->additional_condition) 
                ? json_decode($penawaran->additional_condition, true) 
                : $penawaran->additional_condition;
            
            if (is_array($additionalConditions)) {
                foreach ($additionalConditions as $condition) {
                    $label = $condition['label'] ?? 'Additional Condition';
                    if (isset($condition['produk']) && is_array($condition['produk'])) {
                        foreach ($condition['produk'] as $produk) {
                            $produkPenawaran[] = [
                                'area' => $label,
                                'section' => 'additional_condition',
                                'item' => $produk['nama_produk'] ?? $produk['item'] ?? '',
                                'type' => $produk['code'] ?? '',
                                'dimensi' => '',
                                'panjang' => '',
                                'qty' => $produk['qty'] ?? 0,
                                'satuan' => $produk['satuan'] ?? '',
                                'harga' => $produk['harga'] ?? 0,
                                'total_harga' => $produk['total_harga'] ?? 0,
                            ];
                        }
                    }
                }
            }
        }

        return view('admin.rancangan_anggaran_biaya.edit', compact('rancanganAnggaranBiaya', 'penawaran', 'pemasangan', 'produkPenawaran', 'pemasanganSisa'))->with('rab', $rancanganAnggaranBiaya);
    }

    public function update(Request $request, RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        // Debug: Log request data
        \Log::info('RAB Update - Request data:', [
            'json_pengeluaran_pemasangan' => $request->json_pengeluaran_pemasangan,
            'json_pengeluaran_pemasangan_type' => gettype($request->json_pengeluaran_pemasangan),
            'json_pengeluaran_tukang' => $request->json_pengeluaran_tukang,
            'json_pengeluaran_tukang_type' => gettype($request->json_pengeluaran_tukang),
            'penawaran_id' => $request->penawaran_id,
            'pemasangan_id' => $request->pemasangan_id
        ]);
        
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
            'json_section_material_pendukung' => 'nullable',
            'json_pengeluaran_material_tambahan' => 'nullable|array',
            'json_pengeluaran_pemasangan' => 'nullable',
            'json_pengajuan_harga_tukang' => 'nullable',
            'json_pengeluaran_tukang' => 'nullable',
        ]);
        
        // Handle material utama - check if this is a pintu penawaran first
        $materialUtama = [];
        
        // Get penawaran data to check if it's a pintu penawaran
        $penawaran = Penawaran::find($request->penawaran_id);
        
        if ($penawaran && !empty($penawaran->json_penawaran_pintu)) {
            // This is a pintu penawaran - automatically copy from json_penawaran_pintu
            $materialUtama = $penawaran->json_penawaran_pintu;
        } else {
            // This is a regular penawaran - handle from form inputs
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
        }
        
        // Clean and validate tukang data (remove empty sections)
        // Handle json_pengeluaran_tukang - bisa berupa array atau JSON string
        $tukangDataRaw = $request->json_pengeluaran_tukang ?? [];
        if (is_string($tukangDataRaw)) {
            $tukangDataRaw = json_decode($tukangDataRaw, true) ?? [];
        }
        
        if (is_array($tukangDataRaw) && !empty($tukangDataRaw)) {
            $tukangData = $this->convertTukangDataToNumeric($tukangDataRaw);
        } else {
            $tukangData = [];
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
                                'persentase' => $termin['persentase'] ?? '0%',
                                'status' => $termin['status'] ?? 'Pengajuan'
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
        
        // Clean and validate entertaiment data
        // Handle json_pengeluaran_entertaiment - bisa berupa array atau JSON string
        $entertaimentDataRaw = $request->json_pengeluaran_entertaiment ?? [];
        if (is_string($entertaimentDataRaw)) {
            $entertaimentDataRaw = json_decode($entertaimentDataRaw, true) ?? [];
        }
        
        $entertaimentData = [];
        if (is_array($entertaimentDataRaw) && !empty($entertaimentDataRaw)) {
            foreach ($entertaimentDataRaw as $mr) {
                if (!isset($mr) || !is_array($mr)) continue;
                
                $cleanMaterials = [];
                if (isset($mr['materials']) && is_array($mr['materials']) && !empty($mr['materials'])) {
                    foreach ($mr['materials'] as $material) {
                        if (!isset($material) || !is_array($material)) continue;
                        
                        // Only add material if it has at least supplier, item, or harga_satuan
                        $supplier = $material['supplier'] ?? null;
                        $item = $material['item'] ?? null;
                        $hargaSatuan = !empty($material['harga_satuan']) ? floatval($material['harga_satuan']) : null;
                        
                        if ($supplier || $item || ($hargaSatuan && $hargaSatuan > 0)) {
                            $cleanMaterials[] = [
                                'supplier' => $supplier,
                                'item' => $item,
                                'qty' => !empty($material['qty']) ? floatval($material['qty']) : null,
                                'satuan' => $material['satuan'] ?? null,
                                'harga_satuan' => $hargaSatuan,
                                'sub_total' => !empty($material['sub_total']) ? floatval($material['sub_total']) : null,
                                'status' => $material['status'] ?? 'Disetujui'
                            ];
                        }
                    }
                }
                
                // Only add MR group if it has MR or materials
                $mrValue = $mr['mr'] ?? null;
                if ($mrValue || !empty($cleanMaterials)) {
                    $entertaimentData[] = [
                        'mr' => $mrValue,
                        'tanggal' => $mr['tanggal'] ?? null,
                        'materials' => $cleanMaterials
                    ];
                }
            }
        }
        
        // If no data, set to empty array [] (not null or structure with null values)
        if (empty($entertaimentData)) {
            $entertaimentData = [];
        }
        

        
        $validated['json_pengeluaran_material_utama'] = $materialUtama;
        $validated['json_pengeluaran_material_pendukung'] = $request->json_pengeluaran_material_pendukung ?? [];
        $validated['json_pengeluaran_material_tambahan'] = $request->json_pengeluaran_material_tambahan ?? [];
        
        // Handle json_pengeluaran_pemasangan - convert string to array if needed
        $pemasanganData = $request->json_pengeluaran_pemasangan ?? [];
        if (is_string($pemasanganData)) {
            $pemasanganData = json_decode($pemasanganData, true) ?? [];
        }
        $validated['json_pengeluaran_pemasangan'] = $pemasanganData;
        
        // Handle json_pengajuan_harga_tukang - convert string to array if needed
        $hargaTukangData = $request->json_pengajuan_harga_tukang ?? [];
        if (is_string($hargaTukangData)) {
            $hargaTukangData = json_decode($hargaTukangData, true) ?? [];
        }
        $validated['json_pengajuan_harga_tukang'] = $hargaTukangData;
        
        // Handle json_section_material_pendukung - convert string to array if needed
        $sectionMaterialPendukungData = $request->json_section_material_pendukung ?? [];
        if (is_string($sectionMaterialPendukungData)) {
            $sectionMaterialPendukungData = json_decode($sectionMaterialPendukungData, true) ?? [];
        }
        $validated['json_section_material_pendukung'] = $sectionMaterialPendukungData;
        
        // Debug: Log pemasangan data
        \Log::info('RAB Store Debug - Pemasangan Data', [
            'json_pengeluaran_pemasangan' => $request->json_pengeluaran_pemasangan,
            'validated_pemasangan' => $validated['json_pengeluaran_pemasangan']
        ]);
        
        // Set default values for fields that are not used in edit mode
        $validated['json_pengeluaran_entertaiment'] = $entertaimentData;
        $validated['json_pengeluaran_tukang'] = $tukangData ?? [];
        $validated['json_kerja_tambah'] = $kerjaTambahData ?? [];
        $validated['status_deleted'] = false;
        $validated['status'] = $request->status ?? 'draft';
        $validated['created_by'] = auth()->id();
        $validated['penawaran_id'] = $request->penawaran_id ?? null;
        $validated['pemasangan_id'] = $request->pemasangan_id ?? null;
        $validated['penawaran_pintu'] = ($penawaran && !empty($penawaran->json_penawaran_pintu)) ? 1 : 0;
        
        try {
            // Debug: Log data before update
            \Log::info('RAB Update - Data before update:', [
                'json_pengeluaran_pemasangan' => $validated['json_pengeluaran_pemasangan'],
                'json_pengeluaran_tukang' => $validated['json_pengeluaran_tukang'],
                'penawaran_id' => $validated['penawaran_id'],
                'pemasangan_id' => $validated['pemasangan_id']
            ]);
            
            $rancanganAnggaranBiaya->update($validated);
            
            // Debug: Check if pemasangan data was saved
            $pemasanganData = $rancanganAnggaranBiaya->fresh()->json_pengeluaran_pemasangan;
            $message = 'RAB berhasil diperbarui.';
            if (!empty($pemasanganData)) {
                $message .= ' Data pemasangan tersimpan: ' . count($pemasanganData) . ' item.';
            }
            
            \Log::info('RAB Update - Success:', ['message' => $message]);
            return redirect()->route('admin.rancangan-anggaran-biaya.show', $rancanganAnggaranBiaya)
                ->with('success', 'RAB berhasil diperbarui.');
        } catch (\Exception $e) {
            \Log::error('RAB Update Error: ' . $e->getMessage());
            \Log::error('RAB Update Error Stack: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        $rancanganAnggaranBiaya->update(['status_deleted' => true]);
        return redirect()->route('admin.rancangan-anggaran-biaya.index')->with('success', 'RAB berhasil dihapus.');
    }

    public function updateStatus(Request $request, RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        $request->validate([
            'status' => 'required|in:draft,on_progress,selesai'
        ]);

        $status = $request->status;
        $statusText = '';
        
        switch ($status) {
            case 'draft':
                $statusText = 'Draft';
                break;
            case 'on_progress':
                $statusText = 'On Progress';
                break;
            case 'selesai':
                $statusText = 'Selesai';
                break;
        }

        $rancanganAnggaranBiaya->update(['status' => $status]);
        
        return redirect()->route('admin.rancangan-anggaran-biaya.show', $rancanganAnggaranBiaya)->with('success', "Status RAB berhasil diubah menjadi {$statusText}.");
    }

    public function updateSupervisi(Request $request, RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        $request->validate([
            'supervisi_id' => 'nullable|exists:users,id'
        ]);

        // Jika supervisi_id kosong, set null
        $supervisiId = $request->supervisi_id ?: null;
        
        // Update supervisi
        $rancanganAnggaranBiaya->update(['supervisi_id' => $supervisiId]);
        
        if ($supervisiId) {
            $supervisi = \App\Models\User::find($supervisiId);
            $message = "Supervisi berhasil diubah menjadi {$supervisi->name}.";
        } else {
            $message = "Supervisi berhasil dihapus dari RAB ini.";
        }
        
        return redirect()->route('admin.rancangan-anggaran-biaya.show', $rancanganAnggaranBiaya)->with('success', $message);
    }

    /**
     * Export RAB as PDF
     */
    public function exportPdf(RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        $rancanganAnggaranBiaya->load(['penawaran', 'pemasangan', 'user']);
        $pdf = Pdf::loadView('admin.rancangan_anggaran_biaya.pdf_item', compact('rancanganAnggaranBiaya'));
        $safeFilename = 'RAB_' . preg_replace('/[^A-Za-z0-9_-]/', '-', $rancanganAnggaranBiaya->proyek ?? 'RAB') . '.pdf';
        return $pdf->download($safeFilename);
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

    // ==================== METHODS UNTUK TAMBAH PENGELUARAN ====================

    /**
     * Show form tambah entertainment
     */
    public function tambahEntertainment(RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        $rancanganAnggaranBiaya->load(['penawaran', 'pemasangan']);
        return view('admin.rancangan_anggaran_biaya.tambah-entertainment', compact('rancanganAnggaranBiaya'));
    }

    /**
     * Store entertainment data
     */
    public function storeEntertainment(Request $request, RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        $request->validate([
            'json_pengeluaran_entertaiment' => 'required|array'
        ]);

        // Ambil data existing entertainment
        $existingEntertainment = $rancanganAnggaranBiaya->json_pengeluaran_entertaiment ?? [];
        
        // Process data baru - pastikan harga dan sub total dalam format angka murni
        $processedEntertainment = $request->json_pengeluaran_entertaiment;
        foreach ($processedEntertainment as &$mr) {
            if (isset($mr['materials']) && is_array($mr['materials'])) {
                foreach ($mr['materials'] as &$material) {
                    // Pastikan harga satuan dalam format angka murni
                    if (isset($material['harga_satuan'])) {
                        $material['harga_satuan'] = (int) preg_replace('/[^0-9]/', '', $material['harga_satuan']);
                    }
                    
                    // Pastikan sub total dalam format angka murni
                    if (isset($material['sub_total'])) {
                        $material['sub_total'] = (int) preg_replace('/[^0-9]/', '', $material['sub_total']);
                    }
                }
            }
        }
        
        // Merge dengan data existing
        $mergedEntertainment = array_merge($existingEntertainment, $processedEntertainment);
        
        // Update RAB
        $rancanganAnggaranBiaya->update([
            'json_pengeluaran_entertaiment' => $mergedEntertainment
        ]);

        return redirect()->route('admin.rancangan-anggaran-biaya.show', $rancanganAnggaranBiaya)
            ->with('success', 'Pengeluaran entertainment berhasil ditambahkan.');
    }





    /**
     * Show form tambah tukang
     */
    public function tambahTukang(RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        $rancanganAnggaranBiaya->load(['penawaran', 'pemasangan']);
        return view('admin.rancangan_anggaran_biaya.tambah-tukang', compact('rancanganAnggaranBiaya'));
    }

    /**
     * Store tukang data
     */
    public function storeTukang(Request $request, RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        $request->validate([
            'json_pengeluaran_tukang' => 'nullable|array'
        ]);

        // Data dari form sudah lengkap (existing + baru), langsung update
        $tukangData = $request->json_pengeluaran_tukang ?? [];
        
        // Convert tukang data to numeric format
        $convertedTukangData = $this->convertTukangDataToNumeric($tukangData);
        
        // Update RAB
        $rancanganAnggaranBiaya->update([
            'json_pengeluaran_tukang' => $convertedTukangData
        ]);

        return redirect()->route('admin.rancangan-anggaran-biaya.show', $rancanganAnggaranBiaya)
            ->with('success', 'Pengeluaran tukang berhasil diperbarui.');
    }

    /**
     * Show form tambah kerja tambah
     */
    public function tambahKerjaTambah(RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        $rancanganAnggaranBiaya->load(['penawaran', 'pemasangan']);
        return view('admin.rancangan_anggaran_biaya.tambah-kerja-tambah', compact('rancanganAnggaranBiaya'));
    }

    /**
     * Store kerja tambah data
     */
    public function storeKerjaTambah(Request $request, RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        $request->validate([
            'json_kerja_tambah' => 'required|array'
        ]);

        // Data dari form sudah lengkap (existing + baru), langsung update
        $kerjaTambahData = $request->json_kerja_tambah;
        
        // Convert kerja tambah data to numeric format
        $convertedKerjaTambahData = $this->convertKerjaTambahDataToNumeric($kerjaTambahData);
        
        // Update RAB
        $rancanganAnggaranBiaya->update([
            'json_kerja_tambah' => $convertedKerjaTambahData
        ]);

        return redirect()->route('admin.rancangan-anggaran-biaya.show', $rancanganAnggaranBiaya)
            ->with('success', 'Pengeluaran kerja tambah berhasil diperbarui.');
    }

    // ==================== METHODS UNTUK EDIT SECTION TERPISAH ====================

    /**
     * Edit Pengeluaran Pemasangan
     */
    public function editPemasangan(RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        $rancanganAnggaranBiaya->load(['penawaran', 'pemasangan']);
        return view('admin.rancangan_anggaran_biaya.edit-pemasangan', compact('rancanganAnggaranBiaya'));
    }

    /**
     * Update Pengeluaran Pemasangan
     */
    public function updatePemasangan(Request $request, RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        try {
            \Log::info('Update Pemasangan - Request data:', [
                'json_pengeluaran_pemasangan' => $request->json_pengeluaran_pemasangan,
                'type' => gettype($request->json_pengeluaran_pemasangan),
            ]);

            $request->validate([
                'json_pengeluaran_pemasangan' => 'nullable'
            ]);

            // Handle both JSON string and array format
            $pemasanganData = $request->json_pengeluaran_pemasangan;
            
            // If it's a JSON string, decode it
            if (is_string($pemasanganData)) {
                $pemasanganData = json_decode($pemasanganData, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    \Log::error('JSON decode error: ' . json_last_error_msg());
                    $pemasanganData = [];
                }
            }
            
            // If still not an array, set to empty array
            if (!is_array($pemasanganData)) {
                $pemasanganData = [];
            }
            
            // Clean numeric values
            foreach ($pemasanganData as &$item) {
                if (isset($item['harga_satuan'])) {
                    $item['harga_satuan'] = (float) preg_replace('/[^\d.]/', '', $item['harga_satuan'] ?? 0);
                }
                if (isset($item['total_harga'])) {
                    $item['total_harga'] = (float) preg_replace('/[^\d.]/', '', $item['total_harga'] ?? 0);
                }
            }

            \Log::info('Update Pemasangan - Processed data:', [
                'count' => count($pemasanganData),
                'data' => $pemasanganData
            ]);

            $rancanganAnggaranBiaya->update([
                'json_pengeluaran_pemasangan' => $pemasanganData
            ]);

            \Log::info('Update Pemasangan - Success');

            return redirect()->route('admin.rancangan-anggaran-biaya.show', $rancanganAnggaranBiaya)
                ->with('success', 'Pengeluaran pemasangan berhasil diperbarui.');
        } catch (\Exception $e) {
            \Log::error('Error updating pemasangan: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->with('error', 'Gagal memperbarui pengeluaran pemasangan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Edit Harga Tukang
     */
    public function editHargaTukang(RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        $rancanganAnggaranBiaya->load(['penawaran', 'pemasangan']);
        return view('admin.rancangan_anggaran_biaya.edit-harga-tukang', compact('rancanganAnggaranBiaya'));
    }

    /**
     * Update Harga Tukang
     */
    public function updateHargaTukang(Request $request, RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        try {
            \Log::info('Update Harga Tukang - Request data:', [
                'json_pengajuan_harga_tukang' => $request->json_pengajuan_harga_tukang,
                'type' => gettype($request->json_pengajuan_harga_tukang),
            ]);

            $request->validate([
                'json_pengajuan_harga_tukang' => 'nullable'
            ]);

            // Handle both JSON string and array format
            $hargaTukangData = $request->json_pengajuan_harga_tukang;
            
            // If it's a JSON string, decode it
            if (is_string($hargaTukangData)) {
                $hargaTukangData = json_decode($hargaTukangData, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    \Log::error('JSON decode error: ' . json_last_error_msg());
                    $hargaTukangData = [];
                }
            }
            
            // If still not an array, set to empty array
            if (!is_array($hargaTukangData)) {
                $hargaTukangData = [];
            }
            
            // Clean numeric values
            foreach ($hargaTukangData as &$item) {
                if (isset($item['harga_satuan'])) {
                    $item['harga_satuan'] = (float) preg_replace('/[^\d.]/', '', $item['harga_satuan'] ?? 0);
                }
                if (isset($item['total_harga'])) {
                    $item['total_harga'] = (float) preg_replace('/[^\d.]/', '', $item['total_harga'] ?? 0);
                }
            }

            \Log::info('Update Harga Tukang - Processed data:', [
                'count' => count($hargaTukangData),
                'data' => $hargaTukangData
            ]);

            $rancanganAnggaranBiaya->update([
                'json_pengajuan_harga_tukang' => $hargaTukangData
            ]);

            \Log::info('Update Harga Tukang - Success');

            return redirect()->route('admin.rancangan-anggaran-biaya.show', $rancanganAnggaranBiaya)
                ->with('success', 'Harga tukang berhasil diperbarui.');
        } catch (\Exception $e) {
            \Log::error('Error updating harga tukang: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->with('error', 'Gagal memperbarui harga tukang: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Edit Section Material Pendukung
     */
    public function editSectionMaterialPendukung(RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        $rancanganAnggaranBiaya->load(['penawaran', 'pemasangan']);
        return view('admin.rancangan_anggaran_biaya.edit-section-material-pendukung', compact('rancanganAnggaranBiaya'));
    }

    /**
     * Update Section Material Pendukung
     */
    public function updateSectionMaterialPendukung(Request $request, RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        try {
            \Log::info('Update Section Material Pendukung - Request data:', [
                'json_section_material_pendukung' => $request->json_section_material_pendukung,
                'type' => gettype($request->json_section_material_pendukung),
            ]);

            $request->validate([
                'json_section_material_pendukung' => 'nullable'
            ]);

            // Handle both JSON string and array format
            $sectionMaterialData = $request->json_section_material_pendukung;
            
            // If it's a JSON string, decode it
            if (is_string($sectionMaterialData)) {
                $sectionMaterialData = json_decode($sectionMaterialData, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    \Log::error('JSON decode error: ' . json_last_error_msg());
                    $sectionMaterialData = [];
                }
            }
            
            // If still not an array, set to empty array
            if (!is_array($sectionMaterialData)) {
                $sectionMaterialData = [];
            }
            
            // Clean numeric values and calculate total
            foreach ($sectionMaterialData as &$item) {
                if (isset($item['harga_satuan'])) {
                    $item['harga_satuan'] = (float) preg_replace('/[^\d.]/', '', $item['harga_satuan'] ?? 0);
                }
                if (isset($item['qty'])) {
                    $item['qty'] = (float) ($item['qty'] ?? 0);
                }
                // Calculate total (bulat, tanpa desimal)
                $item['total'] = round(($item['qty'] ?? 0) * ($item['harga_satuan'] ?? 0));
            }

            \Log::info('Update Section Material Pendukung - Processed data:', [
                'count' => count($sectionMaterialData),
                'data' => $sectionMaterialData
            ]);

            $rancanganAnggaranBiaya->update([
                'json_section_material_pendukung' => $sectionMaterialData
            ]);

            \Log::info('Update Section Material Pendukung - Success');

            return redirect()->route('admin.rancangan-anggaran-biaya.show', $rancanganAnggaranBiaya)
                ->with('success', 'Section Material Pendukung berhasil diperbarui.');
        } catch (\Exception $e) {
            \Log::error('Error updating section material pendukung: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->with('error', 'Gagal memperbarui section material pendukung: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Edit Material Pendukung
     */
    public function editMaterialPendukung(RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        $rancanganAnggaranBiaya->load(['penawaran', 'pemasangan']);
        return view('admin.rancangan_anggaran_biaya.edit-material-pendukung', compact('rancanganAnggaranBiaya'));
    }

    /**
     * Update Material Pendukung
     */
    public function updateMaterialPendukung(Request $request, RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        $request->validate([
            'json_pengeluaran_material_pendukung' => 'nullable|array'
        ]);

        $materialPendukungData = $request->json_pengeluaran_material_pendukung ?? [];
        
        // Clean numeric values
        foreach ($materialPendukungData as &$mrGroup) {
            if (isset($mrGroup['materials']) && is_array($mrGroup['materials'])) {
                foreach ($mrGroup['materials'] as &$material) {
                    if (isset($material['harga_satuan'])) {
                        $material['harga_satuan'] = (int) preg_replace('/[^0-9]/', '', $material['harga_satuan'] ?? 0);
                    }
                    if (isset($material['sub_total'])) {
                        $material['sub_total'] = (int) preg_replace('/[^0-9]/', '', $material['sub_total'] ?? 0);
                    }
                }
            }
        }

        $rancanganAnggaranBiaya->update([
            'json_pengeluaran_material_pendukung' => $materialPendukungData
        ]);

        return redirect()->route('admin.rancangan-anggaran-biaya.show', $rancanganAnggaranBiaya)
            ->with('success', 'Pengeluaran material pendukung berhasil diperbarui.');
    }

    /**
     * Edit Material Tambahan
     */
    public function editMaterialTambahan(RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        $rancanganAnggaranBiaya->load(['penawaran', 'pemasangan']);
        return view('admin.rancangan_anggaran_biaya.edit-material-tambahan', compact('rancanganAnggaranBiaya'));
    }

    /**
     * Update Material Tambahan
     */
    public function updateMaterialTambahan(Request $request, RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        $request->validate([
            'json_pengeluaran_material_tambahan' => 'nullable|array'
        ]);

        $materialTambahanData = $request->json_pengeluaran_material_tambahan ?? [];
        
        // Clean numeric values
        foreach ($materialTambahanData as &$mrGroup) {
            if (isset($mrGroup['materials']) && is_array($mrGroup['materials'])) {
                foreach ($mrGroup['materials'] as &$material) {
                    if (isset($material['harga_satuan'])) {
                        $material['harga_satuan'] = (int) preg_replace('/[^0-9]/', '', $material['harga_satuan'] ?? 0);
                    }
                    if (isset($material['sub_total'])) {
                        $material['sub_total'] = (int) preg_replace('/[^0-9]/', '', $material['sub_total'] ?? 0);
                    }
                }
            }
        }

        $rancanganAnggaranBiaya->update([
            'json_pengeluaran_material_tambahan' => $materialTambahanData
        ]);

        return redirect()->route('admin.rancangan-anggaran-biaya.show', $rancanganAnggaranBiaya)
            ->with('success', 'Pengeluaran material tambahan berhasil diperbarui.');
    }

    /**
     * Edit Entertainment
     */
    public function editEntertainment(RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        $rancanganAnggaranBiaya->load(['penawaran', 'pemasangan']);
        return view('admin.rancangan_anggaran_biaya.edit-entertainment', compact('rancanganAnggaranBiaya'));
    }

    /**
     * Update Entertainment
     */
    public function updateEntertainment(Request $request, RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        $request->validate([
            'json_pengeluaran_entertaiment' => 'nullable|array'
        ]);

        $entertainmentData = $request->json_pengeluaran_entertaiment ?? [];
        
        // Clean numeric values
        foreach ($entertainmentData as &$mrGroup) {
            if (isset($mrGroup['materials']) && is_array($mrGroup['materials'])) {
                foreach ($mrGroup['materials'] as &$material) {
                    if (isset($material['harga_satuan'])) {
                        $material['harga_satuan'] = (int) preg_replace('/[^0-9]/', '', $material['harga_satuan'] ?? 0);
                    }
                    if (isset($material['sub_total'])) {
                        $material['sub_total'] = (int) preg_replace('/[^0-9]/', '', $material['sub_total'] ?? 0);
                    }
                }
            }
        }

        $rancanganAnggaranBiaya->update([
            'json_pengeluaran_entertaiment' => $entertainmentData
        ]);

        return redirect()->route('admin.rancangan-anggaran-biaya.show', $rancanganAnggaranBiaya)
            ->with('success', 'Pengeluaran non material berhasil diperbarui.');
    }

    /**
     * Edit Tukang
     */
    public function editTukang(RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        $rancanganAnggaranBiaya->load(['penawaran', 'pemasangan']);
        return view('admin.rancangan_anggaran_biaya.edit-tukang', compact('rancanganAnggaranBiaya'));
    }

    /**
     * Update Tukang
     */
    public function updateTukang(Request $request, RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        $request->validate([
            'json_pengeluaran_tukang' => 'nullable|array'
        ]);

        $tukangData = $request->json_pengeluaran_tukang ?? [];
        $convertedTukangData = $this->convertTukangDataToNumeric($tukangData);

        $rancanganAnggaranBiaya->update([
            'json_pengeluaran_tukang' => $convertedTukangData
        ]);

        return redirect()->route('admin.rancangan-anggaran-biaya.show', $rancanganAnggaranBiaya)
            ->with('success', 'Pengeluaran tukang berhasil diperbarui.');
    }

    /**
     * Edit Kerja Tambah
     */
    public function editKerjaTambah(RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        $rancanganAnggaranBiaya->load(['penawaran', 'pemasangan']);
        return view('admin.rancangan_anggaran_biaya.edit-kerja-tambah', compact('rancanganAnggaranBiaya'));
    }

    /**
     * Update Kerja Tambah
     */
    public function updateKerjaTambah(Request $request, RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        $request->validate([
            'json_kerja_tambah' => 'nullable|array'
        ]);

        $kerjaTambahData = $request->json_kerja_tambah ?? [];
        $convertedKerjaTambahData = $this->convertKerjaTambahDataToNumeric($kerjaTambahData);

        $rancanganAnggaranBiaya->update([
            'json_kerja_tambah' => $convertedKerjaTambahData
        ]);

        return redirect()->route('admin.rancangan-anggaran-biaya.show', $rancanganAnggaranBiaya)
            ->with('success', 'Pengeluaran kerja tambah berhasil diperbarui.');
    }
}
