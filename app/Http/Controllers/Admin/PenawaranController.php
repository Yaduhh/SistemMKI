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
use App\Models\SyaratKetentuan;
use Illuminate\Http\Request;
use App\Http\Requests\StorePenawaranRequest;
use Barryvdh\DomPDF\Facade\Pdf;

class PenawaranController extends Controller
{
    public function index()
    {
        $query = Penawaran::with(['client', 'user']);

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
        if (request('user')) {
            $query->where('id_user', request('user'));
        }

        // Filter by status
        if (request()->has('status') && request('status') !== '') {
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
        $syaratKetentuan = SyaratKetentuan::where('status_deleted', false)->get();
        return view('admin.penawaran.create', compact('users', 'deckings', 'ceilings', 'wallpanels', 'floorings', 'facades', 'syaratKetentuan'));
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
        \Log::info('Penawaran data to be saved:', $data);
        
        $penawaran = Penawaran::create($data);
        
        return redirect()->route('admin.penawaran.index')->with('success', 'Penawaran berhasil dibuat.');
    }

    public function show(Penawaran $penawaran)
    {
        return view('admin.penawaran.show', compact('penawaran'));
    }

    public function edit(Penawaran $penawaran)
    {
        $users = User::all();
        $deckings = Decking::active()->get();
        $ceilings = Ceiling::active()->get();
        $wallpanels = Wallpanel::active()->get();
        $floorings = Flooring::active()->get();
        $facades = Facade::active()->get();
        $syaratKetentuan = SyaratKetentuan::where('status_deleted', false)->get();
        return view('admin.penawaran.edit', compact('penawaran', 'users', 'deckings', 'ceilings', 'wallpanels', 'floorings', 'facades', 'syaratKetentuan'));
    }

    public function update(StorePenawaranRequest $request, Penawaran $penawaran)
    {
        $data = $request->validated();
        
        // Handle syarat_kondisi checkbox
        if ($request->has('syarat_kondisi') && is_array($request->syarat_kondisi)) {
            $data['syarat_kondisi'] = $request->syarat_kondisi;
        } else {
            $data['syarat_kondisi'] = [];
        }
        
        $penawaran->update($data);
        return redirect()->route('admin.penawaran.index')->with('success', 'Penawaran berhasil diupdate.');
    }

    public function destroy(Penawaran $penawaran)
    {
        $penawaran->delete();
        return redirect()->route('admin.penawaran.index')->with('success', 'Penawaran berhasil dihapus.');
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
        
        // Decode JSON fields to arrays
        $json_produk = $penawaran->json_produk ?? [];
        $syarat_kondisi = $penawaran->syarat_kondisi ?? [];

        $pdf = PDF::loadView('admin.penawaran.pdf_item', compact('penawaran', 'json_produk', 'syarat_kondisi'));

        // Sanitize the filename to remove illegal characters
        $safeFilename = str_replace(['/', '\\'], '-', $penawaran->nomor_penawaran);
        
        // Download file PDF with sanitized filename
        return $pdf->download('penawaran_' . $safeFilename . '.pdf');
    }
}
