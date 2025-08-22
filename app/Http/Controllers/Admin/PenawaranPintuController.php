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
use App\Models\Pintu;
use App\Models\SyaratKetentuan;
use App\Traits\NomorPenawaranGenerator;
use Illuminate\Http\Request;
use App\Http\Requests\StorePenawaranRequest;
use Barryvdh\DomPDF\Facade\Pdf;

class PenawaranPintuController extends Controller
{
    use NomorPenawaranGenerator;
    public function index()
    {
        $query = Penawaran::with(['client', 'user'])
            ->where('status_deleted', false)
            ->where('penawaran_pintu', true);

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

        return view('admin.penawaran-pintu.index', compact('penawarans', 'users'));
    }

    public function create()
    {
        $users = User::where('status_deleted', 0)->get();
        $pintus = Pintu::where('status_deleted', false)->get();
        $syaratKetentuan = SyaratKetentuan::where('status_deleted', false)->where('syarat_pintu', 0)->get();
        return view('admin.penawaran-pintu.create', compact('users', 'pintus', 'syaratKetentuan'));
    }

    public function store(StorePenawaranRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->id();
        $data['status'] = 0; // Default status 0
        $data['status_deleted'] = false; // Default status_deleted false
        $data['penawaran_pintu'] = true; // Set penawaran pintu to true
        
        // Handle syarat_kondisi checkbox
        if ($request->has('syarat_kondisi') && is_array($request->syarat_kondisi)) {
            $data['syarat_kondisi'] = $request->syarat_kondisi;
        } else {
            $data['syarat_kondisi'] = [];
        }
        
        // Handle json_penawaran_pintu data
        if ($request->has('json_penawaran_pintu')) {
            $jsonPenawaranPintu = [];
            
            // Proses produk pintu (data langsung)
            foreach ($request->input('json_penawaran_pintu', []) as $key => $value) {
                if (is_numeric($key)) {
                    // Ini adalah produk pintu langsung
                    $jsonPenawaranPintu[$key] = $value;
                } elseif (strpos($key, 'section_') === 0) {
                    // Ini adalah section produk lainnya
                    $jsonPenawaranPintu[$key] = $value;
                }
            }
            
            $data['json_penawaran_pintu'] = $jsonPenawaranPintu;
        } else {
            $data['json_penawaran_pintu'] = [];
        }
        
        // Generate nomor penawaran otomatis berdasarkan bulan
        $data['nomor_penawaran'] = $this->generateNomorPenawaran();
        
        // Debug: Log data yang akan disimpan
        \Log::info('Penawaran Pintu data to be saved:', $data);
        
        try {
            $penawaran = Penawaran::create($data);
            
            // Jika request AJAX, kembalikan JSON response
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Penawaran Pintu berhasil dibuat.',
                    'data' => [
                        'id' => $penawaran->id,
                        'nomor_penawaran' => $penawaran->nomor_penawaran
                    ]
                ]);
            }
            
            // Jika request biasa, redirect
            return redirect()->route('admin.penawaran-pintu.index')->with('success', 'Penawaran Pintu berhasil dibuat.');
            
        } catch (\Exception $e) {
            \Log::error('Error creating Penawaran Pintu: ' . $e->getMessage());
            
            // Jika request AJAX, kembalikan JSON error
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan: ' . $e->getMessage()
                ], 500);
            }
            
            // Jika request biasa, redirect dengan error
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan: ' . $e->getMessage());
        }
    }

    public function show(Penawaran $penawaran)
    {
        
        $penawaran->load(['pemasangans', 'rancanganAnggaranBiayas']);
        return view('admin.penawaran-pintu.show', compact('penawaran'));
    }

    public function edit(Penawaran $penawaran)
    {
        // Ensure this is a pintu penawaran
        if (!$penawaran->penawaran_pintu) {
            abort(404);
        }
        
        $users = User::where('status_deleted', 0)->get();
        $pintus = Pintu::where('status_deleted', false)->get();
        $syaratKetentuan = SyaratKetentuan::where('status_deleted', false)->get();
        return view('admin.penawaran-pintu.edit', compact('penawaran', 'users', 'pintus', 'syaratKetentuan'));
    }

    public function update(StorePenawaranRequest $request, Penawaran $penawaran)
    {
        // Ensure this is a pintu penawaran
        if (!$penawaran->penawaran_pintu) {
            abort(404);
        }
        
        $data = $request->validated();
        
        // Handle syarat_kondisi checkbox
        if ($request->has('syarat_kondisi') && is_array($request->syarat_kondisi)) {
            $data['syarat_kondisi'] = $request->syarat_kondisi;
        } else {
            $data['syarat_kondisi'] = [];
        }
        
        // Handle json_penawaran_pintu data
        if ($request->has('json_penawaran_pintu')) {
            $jsonPenawaranPintu = [];
            
            // Proses produk pintu (data langsung)
            foreach ($request->input('json_penawaran_pintu', []) as $key => $value) {
                if (is_numeric($key)) {
                    // Ini adalah produk pintu langsung
                    $jsonPenawaranPintu[$key] = $value;
                } elseif (strpos($key, 'section_') === 0) {
                    // Ini adalah section produk lainnya
                    $jsonPenawaranPintu[$key] = $value;
                }
            }
            
            $data['json_penawaran_pintu'] = $jsonPenawaranPintu;
        } else {
            $data['json_penawaran_pintu'] = [];
        }
        
        // Debug: Log data yang akan diupdate
        \Log::info('Penawaran Pintu data to be updated:', $data);
        
        try {
            $penawaran->update($data);
            
            // Jika request AJAX, kembalikan JSON response
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Penawaran Pintu berhasil diupdate.',
                    'data' => [
                        'id' => $penawaran->id,
                        'nomor_penawaran' => $penawaran->nomor_penawaran
                    ]
                ]);
            }
            
            // Jika request biasa, redirect
            return redirect()->route('admin.penawaran-pintu.index')->with('success', 'Penawaran Pintu berhasil diupdate.');
            
        } catch (\Exception $e) {
            \Log::error('Error updating Penawaran Pintu: ' . $e->getMessage());
            
            // Jika request AJAX, kembalikan JSON error
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mengupdate: ' . $e->getMessage()
                ], 500);
            }
            
            // Jika request biasa, redirect dengan error
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat mengupdate: ' . $e->getMessage());
        }
    }

    public function destroy(Penawaran $penawaran)
    {
        // Ensure this is a pintu penawaran
        if (!$penawaran->penawaran_pintu) {
            abort(404);
        }
        
        $penawaran->update(['status_deleted' => true]);
        return redirect()->route('admin.penawaran-pintu.index')->with('success', 'Penawaran Pintu berhasil dihapus.');
    }

    public function updateStatus(Request $request, Penawaran $penawaran)
    {
        // Ensure this is a pintu penawaran
        if (!$penawaran->penawaran_pintu) {
            abort(404);
        }
        
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
        
        return redirect()->route('admin.penawaran-pintu.show', $penawaran)->with('success', "Status penawaran pintu berhasil diubah menjadi {$statusText}.");
    }

    /**
     * Get clients by sales ID
     */
    public function getClientsBySales($salesId)
    {
        try {
            $clients = Client::where('created_by', $salesId)
                            ->where('status_deleted', false)
                            ->get(['id', 'nama', 'nama_perusahaan']);
            
            return response()->json([
                'success' => true,
                'data' => $clients
            ]);
        } catch (\Exception $e) {
            \Log::error('Error getting clients by sales: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data client: ' . $e->getMessage()
            ], 500);
        }
    }

    public function cetak(Request $request, $id)
    {
        // Ambil data penawaran berdasarkan ID
        $penawaran = Penawaran::with(['client', 'user.tandaTangan'])->findOrFail($id);
        
        // Debug: Log data tanda tangan
        \Log::info('Penawaran Pintu cetak - User data:', [
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
        
        // Ensure this is a pintu penawaran
        if (!$penawaran->penawaran_pintu) {
            abort(404);
        }
        
        // Decode JSON fields to arrays
        $json_produk = $penawaran->json_produk ?? [];
        $json_penawaran_pintu = $penawaran->json_penawaran_pintu ?? [];
        $syarat_kondisi = $penawaran->syarat_kondisi ?? [];
        
        // Debug: Log syarat_kondisi data
        \Log::info('Syarat & Ketentuan data:', [
            'raw' => $penawaran->syarat_kondisi,
            'processed' => $syarat_kondisi,
            'is_array' => is_array($syarat_kondisi),
            'count' => is_array($syarat_kondisi) ? count($syarat_kondisi) : 0
        ]);

        $pdf = PDF::loadView('admin.penawaran-pintu.pdf_item', compact('penawaran', 'json_produk', 'json_penawaran_pintu', 'syarat_kondisi'));

        // Sanitize the filename to remove illegal characters
        $safeFilename = str_replace(['/', '\\'], '-', $penawaran->nomor_penawaran);
        
        // Download file PDF with sanitized filename
        return $pdf->download('penawaran_pintu_' . $safeFilename . '.pdf');
    }

    /**
     * Buat revisi penawaran pintu
     */
    public function createRevisi(Penawaran $penawaran)
    {
        // Ensure this is a pintu penawaran
        if (!$penawaran->penawaran_pintu) {
            abort(404);
        }

        // Cek apakah bisa dibuat revisi
        if (!$this->canCreateRevisi($penawaran->nomor_penawaran)) {
            return redirect()->back()->with('error', 'Maksimal revisi hanya 3 kali');
        }

        // Ambil data penawaran asli
        $users = User::where('status_deleted', 0)->get();
        $pintus = Pintu::where('status_deleted', false)->get();
        $syaratKetentuan = SyaratKetentuan::where('status_deleted', false)->where('syarat_pintu', 0)->get();

        // Load relasi yang diperlukan
        $penawaran->load(['client', 'user']);

        return view('admin.penawaran-pintu.create-revisi', compact('penawaran', 'users', 'pintus', 'syaratKetentuan'));
    }

    /**
     * Simpan revisi penawaran pintu
     */
    public function storeRevisi(StorePenawaranRequest $request, Penawaran $penawaran)
    {
        // Ensure this is a pintu penawaran
        if (!$penawaran->penawaran_pintu) {
            abort(404);
        }

        $data = $request->validated();
        $data['created_by'] = auth()->id();
        $data['status'] = 0; // Default status 0
        $data['status_deleted'] = false; // Default status_deleted false
        $data['penawaran_pintu'] = true; // Set penawaran pintu to true
        $data['is_revisi'] = true; // Set sebagai revisi
        $data['revisi_from'] = $penawaran->id; // Set referensi ke penawaran asli
        
        // Handle syarat_kondisi checkbox
        if ($request->has('syarat_kondisi') && is_array($request->syarat_kondisi)) {
            $data['syarat_kondisi'] = $request->syarat_kondisi;
        } else {
            $data['syarat_kondisi'] = [];
        }
        
        // Handle json_penawaran_pintu data
        if ($request->has('json_penawaran_pintu')) {
            $jsonPenawaranPintu = [];
            
            // Proses produk pintu (data langsung)
            foreach ($request->input('json_penawaran_pintu', []) as $key => $value) {
                if (is_numeric($key)) {
                    // Ini adalah produk pintu langsung
                    $jsonPenawaranPintu[$key] = $value;
                } elseif (strpos($key, 'section_') === 0) {
                    // Ini adalah section produk lainnya
                    $jsonPenawaranPintu[$key] = $value;
                }
            }
            
            $data['json_penawaran_pintu'] = $jsonPenawaranPintu;
        } else {
            $data['json_penawaran_pintu'] = [];
        }
        
        // Copy data produk dari penawaran asli
        $data['json_produk'] = $penawaran->json_produk ?? [];
        
        // Generate nomor revisi
        $nomorAsli = preg_replace('/\s+R\d+$/', '', $penawaran->nomor_penawaran);
        $data['nomor_penawaran'] = $this->generateNomorRevisi($nomorAsli);
        
        // Debug: Log data yang akan disimpan
        \Log::info('Revisi Penawaran Pintu data to be saved:', $data);
        
        try {
            $revisiPenawaran = Penawaran::create($data);
            
            // Jika request AJAX, kembalikan JSON response
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Revisi Penawaran Pintu berhasil dibuat.',
                    'data' => [
                        'id' => $revisiPenawaran->id,
                        'nomor_penawaran' => $revisiPenawaran->nomor_penawaran
                    ]
                ]);
            }
            
            // Jika request biasa, redirect
            return redirect()->route('admin.penawaran-pintu.show', $revisiPenawaran)->with('success', 'Revisi Penawaran Pintu berhasil dibuat.');
            
        } catch (\Exception $e) {
            \Log::error('Error creating Revisi Penawaran Pintu: ' . $e->getMessage());
            
            // Jika request AJAX, kembalikan JSON error
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan: ' . $e->getMessage()
                ], 500);
            }
            
            // Jika request biasa, redirect dengan error
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan: ' . $e->getMessage());
        }
    }
}
