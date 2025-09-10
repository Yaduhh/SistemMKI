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
            'json_pengeluaran_material_tambahan' => 'nullable|array',
            'json_pengeluaran_pemasangan' => 'nullable',
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
        

        
        $validated['json_pengeluaran_material_utama'] = $materialUtama;
        $validated['json_pengeluaran_material_pendukung'] = $request->json_pengeluaran_material_pendukung ?? [];
        $validated['json_pengeluaran_material_tambahan'] = $request->json_pengeluaran_material_tambahan ?? [];
        
        // Handle json_pengeluaran_pemasangan - convert string to array if needed
        $pemasanganData = $request->json_pengeluaran_pemasangan ?? [];
        if (is_string($pemasanganData)) {
            $pemasanganData = json_decode($pemasanganData, true) ?? [];
        }
        $validated['json_pengeluaran_pemasangan'] = $pemasanganData;
        
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

        return view('admin.rancangan_anggaran_biaya.edit', compact('rancanganAnggaranBiaya', 'penawaran', 'pemasangan', 'produkPenawaran', 'pemasanganSisa'))->with('rab', $rancanganAnggaranBiaya);
    }

    public function update(Request $request, RancanganAnggaranBiaya $rancanganAnggaranBiaya)
    {
        // Debug: Log request data
        \Log::info('RAB Update - Request data:', [
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
            'json_pengeluaran_material_tambahan' => 'nullable|array',
            'json_pengeluaran_pemasangan' => 'nullable',
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
        

        
        $validated['json_pengeluaran_material_utama'] = $materialUtama;
        $validated['json_pengeluaran_material_pendukung'] = $request->json_pengeluaran_material_pendukung ?? [];
        $validated['json_pengeluaran_material_tambahan'] = $request->json_pengeluaran_material_tambahan ?? [];
        
        // Handle json_pengeluaran_pemasangan - convert string to array if needed
        $pemasanganData = $request->json_pengeluaran_pemasangan ?? [];
        if (is_string($pemasanganData)) {
            $pemasanganData = json_decode($pemasanganData, true) ?? [];
        }
        $validated['json_pengeluaran_pemasangan'] = $pemasanganData;
        
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
            // Debug: Log data before update
            \Log::info('RAB Update - Data before update:', [
                'json_pengeluaran_pemasangan' => $validated['json_pengeluaran_pemasangan'],
                'penawaran_id' => $validated['penawaran_id'],
                'pemasangan_id' => $validated['pemasangan_id']
            ]);
            
            $rancanganAnggaranBiaya->update($validated);
            
            // Debug: Check if pemasangan data was saved
            $pemasanganData = $rancanganAnggaranBiaya->fresh()->json_pengeluaran_pemasangan;
            $message = 'RAB berhasil diperbarui.';
            if (!empty($pemasanganData)) {
                $message .= ' Data pemasangan tersimpan: ' . count($pemasanganData) . ' item.';
            } else {
                $message .= ' WARNING: Data pemasangan kosong!';
            }
            
            \Log::info('RAB Update - Success:', ['message' => $message]);
            return redirect()->route('admin.rancangan-anggaran-biaya.index')->with('success', $message);
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
}
