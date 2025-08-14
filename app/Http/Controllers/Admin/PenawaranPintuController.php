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
use Illuminate\Http\Request;
use App\Http\Requests\StorePenawaranRequest;
use Barryvdh\DomPDF\Facade\Pdf;

class PenawaranPintuController extends Controller
{
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
        $syaratKetentuan = SyaratKetentuan::where('status_deleted', false)->get();
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
        
        // Generate nomor penawaran otomatis
        $lastPenawaran = Penawaran::latest()->first();
        $lastNumber = $lastPenawaran ? $lastPenawaran->nomor_penawaran : null;

        // Ambil bulan dan tahun saat ini
        $month = date('m');
        $year = date('y');

        // Format nomor penawaran: A/MKI/MM/YY
        $prefix = 'A/MKI/' . $month . '/' . $year;
        $number = $lastNumber ? (int)substr($lastNumber, 0, 2) + 1 : 1;
        $data['nomor_penawaran'] = str_pad($number, 2, '0', STR_PAD_LEFT) . $prefix;
        
        // Debug: Log data yang akan disimpan
        \Log::info('Penawaran Pintu data to be saved:', $data);
        
        $penawaran = Penawaran::create($data);
        
        return redirect()->route('admin.penawaran-pintu.index')->with('success', 'Penawaran Pintu berhasil dibuat.');
    }

    public function show(Penawaran $penawaran)
    {
        // Ensure this is a pintu penawaran
        if (!$penawaran->penawaran_pintu) {
            abort(404);
        }
        
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
        
        // Debug: Log data yang akan diupdate
        \Log::info('Penawaran Pintu data to be updated:', $data);
        
        $penawaran->update($data);
        return redirect()->route('admin.penawaran-pintu.index')->with('success', 'Penawaran Pintu berhasil diupdate.');
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
        $clients = Client::where('created_by', $salesId)
                        ->where('status_deleted', false)
                        ->get(['id', 'nama', 'nama_perusahaan']);
        
        return response()->json($clients);
    }

    public function cetak(Request $request, $id)
    {
        // Ambil data penawaran berdasarkan ID
        $penawaran = Penawaran::with(['client', 'user'])->findOrFail($id);
        
        // Ensure this is a pintu penawaran
        if (!$penawaran->penawaran_pintu) {
            abort(404);
        }
        
        // Decode JSON fields to arrays
        $json_produk = $penawaran->json_produk ?? [];
        $json_penawaran_pintu = $penawaran->json_penawaran_pintu ?? [];
        $syarat_kondisi = $penawaran->syarat_kondisi ?? [];

        $pdf = PDF::loadView('admin.penawaran-pintu.pdf_item', compact('penawaran', 'json_produk', 'json_penawaran_pintu', 'syarat_kondisi'));

        // Sanitize the filename to remove illegal characters
        $safeFilename = str_replace(['/', '\\'], '-', $penawaran->nomor_penawaran);
        
        // Download file PDF with sanitized filename
        return $pdf->download('penawaran_pintu_' . $safeFilename . '.pdf');
    }
}
