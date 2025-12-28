<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penawaran;
use App\Models\Client;
use App\Models\User;
use App\Models\Decking;
use App\Models\Ceiling;
use App\Models\Wallpanel;
use App\Models\Flooring;
use App\Models\Facade;
use App\Models\Hollow;
use App\Models\RotanSintetis;
use App\Models\SyaratKetentuan;
use App\Traits\NomorPenawaranGenerator;
use Illuminate\Http\Request;
use App\Http\Requests\StorePenawaranRequest;
use Barryvdh\DomPDF\Facade\Pdf;

class PenawaranController extends Controller
{
    use NomorPenawaranGenerator;

    public function index()
    {
        $query = Penawaran::with(['client', 'user'])->where('status_deleted', false)->where('penawaran_pintu', false);

        // Search functionality
        if (request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('nomor_penawaran', 'like', "%{$search}%")
                  ->orWhere('judul_penawaran', 'like', "%{$search}%")
                  ->orWhereHas('client', function($clientQuery) use ($search) {
                      $clientQuery->where('nama', 'like', "%{$search}%")
                                 ->orWhere('nama_perusahaan', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by user (sales)
        if (request('user') && request('user') !== '') {
            $query->where('id_user', request('user'));
        }

        // Filter by status
        if (request('status') && request('status') !== '') {
            $query->where('status', request('status'));
        }

        // Get users for filter dropdown
        $users = User::where('status_deleted', 0)->get();

        // Get filtered and paginated results
        $penawarans = $query->latest()->paginate(12);

        return view('admin.penawaran.index', compact('penawarans', 'users'));
    }

    public function create()
    {
        $users = User::where('status_deleted', 0)->get();
        $deckings = Decking::active()->get();
        $ceilings = Ceiling::active()->get();
        $wallpanels = Wallpanel::active()->get();
        $floorings = Flooring::active()->get();
        $facades = Facade::active()->get();
        $hollows = Hollow::active()->get();
        $rotanSintetis = RotanSintetis::active()->get();
        $syaratKetentuan = SyaratKetentuan::where('status_deleted', false)->where('syarat_pintu', 0)->get();
        
        // Get nomor penawaran terakhir sebagai referensi
        $lastPenawaran = Penawaran::where('status_deleted', false)
            ->where('penawaran_pintu', false)
            ->latest()
            ->first();
        
        $lastNomorPenawaran = $lastPenawaran ? $lastPenawaran->nomor_penawaran : null;
        
        return view('admin.penawaran.create', compact('users', 'deckings', 'ceilings', 'wallpanels', 'floorings', 'facades', 'hollows', 'rotanSintetis', 'syaratKetentuan', 'lastNomorPenawaran'));
    }

    public function store(StorePenawaranRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->id();
        $data['status'] = 0; // Default status 0
        $data['status_deleted'] = false; // Default status_deleted false
        
        // Handle syarat_kondisi checkbox
        if ($request->has('syarat_kondisi') && is_array($request->syarat_kondisi)) {
            $data['syarat_kondisi'] = $request->syarat_kondisi;
        } else {
            $data['syarat_kondisi'] = [];
        }
        
        // Handle additional_condition (aksesoris/hollow) - convert to JSON string for text field
        if ($request->has('additional_condition') && is_array($request->additional_condition) && count($request->additional_condition) > 0) {
            // Filter out empty conditions
            $filteredConditions = array_filter($request->additional_condition, function($condition) {
                return isset($condition['produk']) && is_array($condition['produk']) && count($condition['produk']) > 0;
            });
            
            if (count($filteredConditions) > 0) {
                $data['additional_condition'] = json_encode(array_values($filteredConditions));
            } else {
                $data['additional_condition'] = null;
            }
        } else {
            $data['additional_condition'] = null;
        }
        
        // Nomor penawaran sekarang input manual, tidak auto-generate
        
        // Debug: Log data yang akan disimpan
        \Log::info('Penawaran data to be saved:', $data);
        
        $penawaran = Penawaran::create($data);
        
        return redirect()->route('admin.penawaran.index')->with('success', 'Penawaran berhasil dibuat.');
    }

    public function show(Penawaran $penawaran)
    {
        $penawaran->load(['pemasangans', 'rancanganAnggaranBiayas']);
        return view('admin.penawaran.show', compact('penawaran'));
    }

    public function edit(Penawaran $penawaran)
    {
        $users = User::where('status_deleted', 0)->get();
        $deckings = Decking::active()->get();
        $ceilings = Ceiling::active()->get();
        $wallpanels = Wallpanel::active()->get();
        $floorings = Flooring::active()->get();
        $facades = Facade::active()->get();
        $hollows = Hollow::active()->get();
        $rotanSintetis = RotanSintetis::active()->get();
        $syaratKetentuan = SyaratKetentuan::where('status_deleted', false)->where('syarat_pintu', 0)->get();
        return view('admin.penawaran.edit', compact('penawaran', 'users', 'deckings', 'ceilings', 'wallpanels', 'floorings', 'facades', 'hollows', 'rotanSintetis', 'syaratKetentuan'));
    }

    public function update(StorePenawaranRequest $request, Penawaran $penawaran)
    {
        try {
            $data = $request->validated();
            
            // Handle syarat_kondisi checkbox
            if ($request->has('syarat_kondisi') && is_array($request->syarat_kondisi)) {
                $data['syarat_kondisi'] = $request->syarat_kondisi;
            } else {
                $data['syarat_kondisi'] = [];
            }
            
            // Handle additional_condition (aksesoris/hollow) - convert to JSON string for text field
            if ($request->has('additional_condition') && is_array($request->additional_condition) && count($request->additional_condition) > 0) {
                // Filter out empty conditions
                $filteredConditions = array_filter($request->additional_condition, function($condition) {
                    return isset($condition['produk']) && is_array($condition['produk']) && count($condition['produk']) > 0;
                });
                
                if (count($filteredConditions) > 0) {
                    $data['additional_condition'] = json_encode(array_values($filteredConditions));
                } else {
                    $data['additional_condition'] = null;
                }
            } else {
                $data['additional_condition'] = null;
            }
            
            // Debug: Log data yang akan diupdate
            \Log::info('Penawaran data to be updated:', $data);
            
            $penawaran->update($data);
            return redirect()->route('admin.penawaran.index')->with('success', 'Penawaran berhasil diupdate.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error on update:', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Error updating penawaran:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengupdate penawaran: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Penawaran $penawaran)
    {
        $penawaran->update(['status_deleted' => true]);
        return redirect()->route('admin.penawaran.index')->with('success', 'Penawaran berhasil dihapus.');
    }

    public function updateStatus(Request $request, Penawaran $penawaran)
    {
        $request->validate([
            'status' => 'required|in:0,1,2'
        ]);

        $status = $request->status;
        $statusText = '';
        
        switch ($status) {
            case 0:
                $statusText = 'Draft';
                break;
            case 1:
                $statusText = 'WIN';
                break;
            case 2:
                $statusText = 'LOSE';
                break;
        }

        $penawaran->update(['status' => $status]);
        
        return redirect()->route('admin.penawaran.show', $penawaran)->with('success', "Status penawaran berhasil diubah menjadi {$statusText}.");
    }

    /**
     * Buat revisi penawaran
     */
    public function createRevisi(Penawaran $penawaran)
    {
        // Cek apakah bisa dibuat revisi
        if (!$this->canCreateRevisi($penawaran->nomor_penawaran)) {
            return redirect()->back()->with('error', 'Maksimal revisi hanya 3 kali');
        }

        // Ambil data penawaran asli
        $users = User::where('status_deleted', 0)->get();
        $deckings = Decking::active()->get();
        $ceilings = Ceiling::active()->get();
        $wallpanels = Wallpanel::active()->get();
        $floorings = Flooring::active()->get();
        $facades = Facade::active()->get();
        $hollows = Hollow::active()->get();
        $rotanSintetis = RotanSintetis::active()->get();
        $syaratKetentuan = SyaratKetentuan::where('status_deleted', false)->where('syarat_pintu', 0)->get();

        // Load relasi yang diperlukan
        $penawaran->load(['client', 'user']);

        return view('admin.penawaran.create-revisi', compact('penawaran', 'users', 'deckings', 'ceilings', 'wallpanels', 'floorings', 'facades', 'hollows', 'rotanSintetis', 'syaratKetentuan'));
    }

    /**
     * Simpan revisi penawaran
     */
    public function storeRevisi(StorePenawaranRequest $request, Penawaran $penawaran)
    {
        try {
            $data = $request->validated();
            $data['created_by'] = auth()->id();
            $data['status'] = 0; // Default status 0
            $data['status_deleted'] = false; // Default status_deleted false
            $data['is_revisi'] = true; // Set sebagai revisi
            $data['revisi_from'] = $penawaran->id; // Set referensi ke penawaran asli
            
            // Handle syarat_kondisi checkbox
            if ($request->has('syarat_kondisi') && is_array($request->syarat_kondisi)) {
                $data['syarat_kondisi'] = $request->syarat_kondisi;
            } else {
                $data['syarat_kondisi'] = [];
            }
            
            // Handle additional_condition (aksesoris/hollow) - convert to JSON string for text field
            if ($request->has('additional_condition') && is_array($request->additional_condition) && count($request->additional_condition) > 0) {
                // Filter out empty conditions
                $filteredConditions = array_filter($request->additional_condition, function($condition) {
                    return isset($condition['produk']) && is_array($condition['produk']) && count($condition['produk']) > 0;
                });
                
                if (count($filteredConditions) > 0) {
                    $data['additional_condition'] = json_encode(array_values($filteredConditions));
                } else {
                    $data['additional_condition'] = null;
                }
            } else {
                $data['additional_condition'] = null;
            }
            
            // Copy data produk dari penawaran asli (jika tidak ada perubahan dari form)
            // Jika ada perubahan dari form, gunakan data dari request
            if (!isset($data['json_produk']) || empty($data['json_produk'])) {
                $data['json_produk'] = $penawaran->json_produk ?? [];
            }
            
            // Generate nomor revisi
            $nomorAsli = preg_replace('/\s+R\d+$/', '', $penawaran->nomor_penawaran);
            $data['nomor_penawaran'] = $this->generateNomorRevisi($nomorAsli);
            
            // Debug: Log data yang akan disimpan
            \Log::info('Revisi Penawaran data to be saved:', $data);
            
            $revisiPenawaran = Penawaran::create($data);
            
            return redirect()->route('admin.penawaran.show', $revisiPenawaran)->with('success', 'Revisi penawaran berhasil dibuat.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error on storeRevisi:', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Error storing revisi penawaran:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan revisi penawaran: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Get clients by sales ID
     */
    public function getClientsBySales($salesId)
    {
        $clients = Client::where('created_by', $salesId)
                        ->where('status_deleted', false)
                        ->get(['id', 'nama', 'nama_perusahaan']);
        
        return response()->json($clients);
    }

    public function getHollows()
    {
        try {
            $hollows = Hollow::active()->get(['id', 'code', 'slug', 'nama_produk', 'satuan', 'harga']);
            
            \Log::info('Hollows fetched:', ['count' => $hollows->count()]);
            
            return response()->json($hollows, 200, [
                'Content-Type' => 'application/json',
                'Cache-Control' => 'no-cache'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching hollows: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'error' => 'Failed to fetch hollows',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function cetak(Request $request, $id)
    {
        // Ambil data penawaran berdasarkan ID
        $penawaran = Penawaran::with(['client', 'user.tandaTangan'])->findOrFail($id);
        
        // Debug: Log data tanda tangan
        \Log::info('Penawaran cetak - User data:', [
            'user_id' => $penawaran->user->id ?? 'null',
            'user_name' => $penawaran->user->name ?? 'null',
            'tanda_tangan' => $penawaran->user->tandaTangan ?? 'null',
            'tanda_tangan_ttd' => $penawaran->user->tandaTangan->ttd ?? 'null'
        ]);
        
        // Copy tanda tangan ke public folder jika ada
        if ($penawaran->user && $penawaran->user->tandaTangan) {
            $sourcePath = storage_path('app/public/' . $penawaran->user->tandaTangan->ttd);
            $publicPath = public_path('assets/images/tanda-tangan/');
            
            // Buat folder jika belum ada
            if (!file_exists($publicPath)) {
                mkdir($publicPath, 0755, true);
            }
            
            $filename = basename($penawaran->user->tandaTangan->ttd);
            $destinationPath = $publicPath . $filename;
            
            if (file_exists($sourcePath)) {
                copy($sourcePath, $destinationPath);
                \Log::info('Tanda tangan copied to public:', ['destination' => $destinationPath]);
            }
        }
        
        // Decode JSON fields to arrays
        $json_produk = $penawaran->json_produk ?? [];
        $syarat_kondisi = $penawaran->syarat_kondisi ?? [];

        $pdf = PDF::loadView('admin.penawaran.pdf_item', compact('penawaran', 'json_produk', 'syarat_kondisi'));

        // Sanitize the filename to remove illegal characters
        $safeFilename = str_replace(['/', '\\'], '-', $penawaran->nomor_penawaran);
        
        // Download file PDF with sanitized filename
        return $pdf->download('penawaran_' . $safeFilename . '.pdf');
    }

    public function cetakFull(Request $request, $id)
    {
        // Ambil data penawaran berdasarkan ID
        $penawaran = Penawaran::with(['client', 'user.tandaTangan', 'pemasangans'])->findOrFail($id);
        
        // Cek apakah ada pemasangan terkait
        $pemasangans = $penawaran->pemasangans ?? collect();
        
        if ($pemasangans->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada pemasangan terkait untuk penawaran ini.');
        }
        
        // Copy tanda tangan ke public folder jika ada
        if ($penawaran->user && $penawaran->user->tandaTangan) {
            $sourcePath = storage_path('app/public/' . $penawaran->user->tandaTangan->ttd);
            $publicPath = public_path('assets/images/tanda-tangan/');
            
            // Buat folder jika belum ada
            if (!file_exists($publicPath)) {
                mkdir($publicPath, 0755, true);
            }
            
            $filename = basename($penawaran->user->tandaTangan->ttd);
            $destinationPath = $publicPath . $filename;
            
            if (file_exists($sourcePath)) {
                copy($sourcePath, $destinationPath);
            }
        }
        
        // Decode JSON fields untuk penawaran
        $json_produk = $penawaran->json_produk ?? [];
        $syarat_kondisi = $penawaran->syarat_kondisi ?? [];
        
        // Render view penawaran sebagai HTML string
        $penawaranHtml = view('admin.penawaran.pdf_item', compact('penawaran', 'json_produk', 'syarat_kondisi'))->render();
        
        // Extract head (untuk CSS) dan body content dari penawaran HTML
        preg_match('/<head>(.*?)<\/head>/is', $penawaranHtml, $penawaranHeadMatches);
        preg_match('/<body[^>]*>(.*?)<\/body>/is', $penawaranHtml, $penawaranBodyMatches);
        $penawaranHead = $penawaranHeadMatches[1] ?? '';
        $penawaranBody = $penawaranBodyMatches[1] ?? '';
        
        // Render view pemasangan untuk setiap pemasangan dan gabungkan
        $pemasanganBodies = [];
        $pemasanganHeads = [];
        foreach ($pemasangans as $pemasangan) {
            $pemasangan->load(['client', 'sales']);
            $json_pemasangan = $pemasangan->json_pemasangan ?? [];
            $json_syarat_kondisi = $pemasangan->json_syarat_kondisi ?? [];
            
            // Tentukan logo berdasarkan nama perusahaan
            $company = $pemasangan->client->nama_perusahaan ?? '';
            if (stripos($company, 'WPC MAKMUR ABADI') !== false) {
                $logo = public_path('assets/images/logoMki.png');
            } else {
                $logo = public_path('assets/images/wpcmakmurabadi.jpg');
            }
            $ttd = public_path('assets/images/ttdCiyuli.jpg');
            
            // Render view pemasangan
            $pemasanganHtml = view('admin.pemasangan.pdf_item', compact('pemasangan', 'json_pemasangan', 'json_syarat_kondisi', 'logo', 'ttd'))->render();
            
            // Extract head (untuk CSS) dan body content dari pemasangan HTML
            preg_match('/<head>(.*?)<\/head>/is', $pemasanganHtml, $pemasanganHeadMatches);
            preg_match('/<body[^>]*>(.*?)<\/body>/is', $pemasanganHtml, $pemasanganBodyMatches);
            $pemasanganHead = $pemasanganHeadMatches[1] ?? '';
            $pemasanganBody = $pemasanganBodyMatches[1] ?? '';
            
            // Simpan head untuk digabungkan nanti
            if (!empty($pemasanganHead)) {
                $pemasanganHeads[] = $pemasanganHead;
            }
            
            // Tambahkan page break sebelum pemasangan
            $pemasanganBody = '<div style="page-break-before: always;"></div>' . $pemasanganBody;
            
            $pemasanganBodies[] = $pemasanganBody;
        }
        
        // Gabungkan semua head (CSS) dan body content dalam satu HTML document
        $allHeads = $penawaranHead;
        if (!empty($pemasanganHeads)) {
            $allHeads .= implode('', $pemasanganHeads);
        }
        
        $combinedHtml = '<!DOCTYPE html><html><head><title>' . $penawaran->judul_penawaran . ' - Full</title>' . 
                        $allHeads . 
                        '</head><body>' . 
                        $penawaranBody . implode('', $pemasanganBodies) . 
                        '</body></html>';
        
        // Generate PDF dari HTML yang sudah digabungkan
        $pdf = PDF::loadHTML($combinedHtml);

        // Sanitize the filename to remove illegal characters
        $safeFilename = str_replace(['/', '\\'], '-', $penawaran->nomor_penawaran);
        
        // Download file PDF with sanitized filename
        return $pdf->download('penawaran_full_' . $safeFilename . '.pdf');
    }
}
