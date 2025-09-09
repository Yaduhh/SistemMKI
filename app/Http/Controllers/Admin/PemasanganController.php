<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemasangan;
use App\Models\Penawaran;
use App\Models\Client;
use App\Models\User;
use App\Models\SyaratPemasangan;
use Barryvdh\DomPDF\Facade\Pdf;

class PemasanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \App\Models\Pemasangan::with(['client', 'sales'])->where('status_deleted', 0);
        if ($request->filled('client')) {
            $query->where('id_client', $request->client);
        }
        if ($request->filled('sales')) {
            $query->where('id_sales', $request->sales);
        }
        if ($request->filled('start')) {
            $query->whereDate('tanggal_pemasangan', '>=', $request->start);
        }
        if ($request->filled('end')) {
            $query->whereDate('tanggal_pemasangan', '<=', $request->end);
        }
        $pemasangans = $query->orderByDesc('id')->paginate(15)->appends($request->all());
        $clients = \App\Models\Client::where('status_deleted', 0)->orderBy('nama')->get();
        $salesList = \App\Models\User::where('role', 2)->where('status_deleted', 0)->orderBy('name')->get();
        return view('admin.pemasangan.index', compact('pemasangans', 'clients', 'salesList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $penawaranId = $request->get('penawaran_id');
        $penawaran = Penawaran::with(['client', 'user'])->findOrFail($penawaranId);
        $client = $penawaran->client;
        $sales = $penawaran->user;
        
        // Filter syarat pemasangan berdasarkan jenis penawaran
        if ($penawaran->penawaran_pintu) {
            // Jika penawaran pintu, ambil syarat pemasangan pintu
            $syaratPemasangan = SyaratPemasangan::where('status_deleted', 0)
                ->where('syarat_pintu', 1)
                ->get();
        } else {
            // Jika penawaran biasa, ambil syarat pemasangan biasa
            $syaratPemasangan = SyaratPemasangan::where('status_deleted', 0)
                ->where('syarat_pintu', 0)
                ->get();
        }
        
        return view('admin.pemasangan.create', compact('penawaran', 'client', 'sales', 'syaratPemasangan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_pemasangan' => 'required|date',
            'id_penawaran' => 'required|exists:penawaran,id',
            'id_client' => 'required|exists:clients,id',
            'id_sales' => 'required|exists:users,id',
            'judul_pemasangan' => 'required|string|max:255',
            'json_pemasangan' => 'required|array',
            'total' => 'required|numeric',
            'diskon' => 'nullable|numeric',
            'grand_total' => 'required|numeric',
            'json_syarat_kondisi' => 'nullable|array',
            'logo' => 'nullable|string|max:100',
        ]);
        $data = $request->all();
        $last = Pemasangan::orderByDesc('id')->first();
        $lastNumber = $last ? (int)preg_replace('/[^0-9]/', '', substr($last->nomor_pemasangan, 0, 3)) : 0;
        $nextNumber = $lastNumber + 1;
        if ($nextNumber < 10) {
            $numberStr = str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
        } else {
            $numberStr = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        }
        $month = date('m');
        $year = date('y');
        $data['nomor_pemasangan'] = $numberStr . 'B/MKI/' . $month . '/' . $year;
        $data['created_by'] = auth()->id();
        $data['status'] = 0;
        $data['status_deleted'] = 0;
        $pemasangan = Pemasangan::create($data);
        return redirect()->route('admin.pemasangan.show', $pemasangan->id)->with('success', 'Pemasangan berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pemasangan = \App\Models\Pemasangan::with(['client', 'sales'])->findOrFail($id);
        return view('admin.pemasangan.show', compact('pemasangan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pemasangan = Pemasangan::with(['penawaran', 'client', 'sales'])->findOrFail($id);
        $penawaran = $pemasangan->penawaran;
        $client = $pemasangan->client;
        $sales = $pemasangan->sales;
        
        // Filter syarat pemasangan berdasarkan jenis penawaran
        if ($penawaran->penawaran_pintu) {
            // Jika penawaran pintu, ambil syarat pemasangan pintu
            $syaratPemasangan = SyaratPemasangan::where('status_deleted', 0)
                ->where('syarat_pintu', 1)
                ->get();
        } else {
            // Jika penawaran biasa, ambil syarat pemasangan biasa
            $syaratPemasangan = SyaratPemasangan::where('status_deleted', 0)
                ->where('syarat_pintu', 0)
                ->get();
        }
        
        return view('admin.pemasangan.edit', compact('pemasangan', 'penawaran', 'client', 'sales', 'syaratPemasangan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_pemasangan' => 'required|date',
            'judul_pemasangan' => 'required|string|max:255',
            'json_pemasangan' => 'required|array',
            'total' => 'required|numeric',
            'diskon' => 'nullable|numeric',
            'grand_total' => 'required|numeric',
            'json_syarat_kondisi' => 'nullable|array',
            'logo' => 'nullable|string|max:100',
        ]);

        $pemasangan = Pemasangan::findOrFail($id);
        $data = $request->all();
        
        $pemasangan->update($data);
        
        return redirect()->route('admin.pemasangan.show', $pemasangan->id)->with('success', 'Pemasangan berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pemasangan = \App\Models\Pemasangan::findOrFail($id);
        $pemasangan->status_deleted = 1;
        $pemasangan->save();
        return redirect()->route('admin.pemasangan.index')->with('success', 'Pemasangan berhasil dihapus.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:0,1,2'
        ]);
        $pemasangan = \App\Models\Pemasangan::findOrFail($id);
        $pemasangan->status = $request->status;
        $pemasangan->save();
        return redirect()->route('admin.pemasangan.show', $pemasangan->id)->with('success', 'Status pemasangan berhasil diubah.');
    }

    /**
     * Cetak PDF pemasangan
     */
    public function cetak(Request $request, $id)
    {
        $pemasangan = Pemasangan::with(['client', 'sales'])->findOrFail($id);
        // Ambil json_produk jika ada, fallback ke json_pemasangan
        $json_produk = $pemasangan->json_produk ?? $pemasangan->json_pemasangan ?? [];
        $json_pemasangan = $pemasangan->json_pemasangan ?? [];
        $json_syarat_kondisi = $pemasangan->json_syarat_kondisi ?? [];

        // Tentukan logo berdasarkan nama perusahaan
        $company = $pemasangan->client->nama_perusahaan ?? '';
        if (stripos($company, 'WPC MAKMUR ABADI') !== false) {
            $logo = public_path('assets/images/logoMki.png');
        } else {
            $logo = public_path('assets/images/wpcmakmurabadi.jpg');
        }

        $pdf = Pdf::loadView('admin.pemasangan.pdf_item', compact('pemasangan', 'json_produk', 'json_pemasangan', 'json_syarat_kondisi', 'logo'));
        $safeFilename = str_replace(['/', '\\'], '-', $pemasangan->nomor_pemasangan);
        return $pdf->download('pemasangan_' . $safeFilename . '.pdf');
    }
}
