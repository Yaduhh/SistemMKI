<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SuratJalan;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class SuratJalanController extends Controller
{
    public function cetak(Request $request, $id)
    {
      // Ambil data Surat Jalan dari database berdasarkan ID
        $suratJalan = SuratJalan::with('author')->findOrFail($id);
        $author = User::find($suratJalan->author);
        $items = json_decode($suratJalan->json, true);

        // Pastikan bahwa data item adalah array
        if (!is_array($items)) {
            $items = [];
        }

        $pdf = PDF::loadView('admin.surat_jalan.pdf_item', compact('suratJalan', 'items', 'author'));
        
        $safeFilename = str_replace(['/', '\\'], '-', $suratJalan->nomor_surat);
        
        // Download file PDF with sanitized filename
        return $pdf->download('surat_jalan_' . $safeFilename . '.pdf');
    }

    // Display list of Surat Jalan
    public function index()
    {
        $suratJalans = SuratJalan::where('deleted_status', false)->get();
        return view('admin.surat_jalan.index', compact('suratJalans'));
    }

    // Show form to create a new Surat Jalan
    public function create()
    {
        return view('admin.surat_jalan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_po' => 'required|string|max:255',
            'no_spp' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
            'proyek' => 'required|string|max:255',
            'penerima' => 'required|string|max:255',
            'items' => 'required|array',
            'author' => 'required|exists:users,id',
            'pengirim' => 'required|string|max:255',
            'security' => 'required|string|max:255',
            'diketahui' => 'required|string|max:255',
            'disetujui' => 'required|string|max:255',
            'diterima' => 'required|string|max:255',
        ]);

        // Mengubah data items menjadi array yang terstruktur
        $items = [];
        foreach ($request->items as $item) {
            $items[] = [
                'item' => $item['item'] ?? null,
                'kode' => $item['kode'] ?? null,
                'panjang' => $item['panjang'] ?? null,
                'jumlah' => $item['jumlah'] ?? null,
                'satuan' => $item['satuan'] ?? null,
                'keterangan' => $item['keterangan'] ?? null,
            ];
        }

        // Mendapatkan bulan dan tahun saat ini
        $month = date('m');
        $year = date('Y');

        // Mendapatkan nomor Surat Jalan terbaru
        $latestSuratJalan = SuratJalan::whereYear('created_at', $year)
                                        ->whereMonth('created_at', $month)
                                        ->orderByDesc('created_at')
                                        ->first();

        // Increment counter
        $counter = $latestSuratJalan ? intval(substr($latestSuratJalan->nomor_surat, -3)) + 1 : 1;

        // Format nomor Surat Jalan
        $formattedCounter = str_pad($counter, 3, '0', STR_PAD_LEFT);
        $nomor_surat = "SJ-MKI/{$month}/{$year}/{$formattedCounter}";

        // Simpan Surat Jalan
        SuratJalan::create([
            'nomor_surat' => $nomor_surat,
            'no_po' => $request->no_po,
            'no_spp' => $request->no_spp,
            'keterangan' => $request->keterangan,
            'tujuan' => $request->tujuan,
            'proyek' => $request->proyek,
            'penerima' => $request->penerima,
            'json' => json_encode($items), // Simpan items dalam format JSON yang terstruktur
            'author' => $request->author,
            'pengirim' => $request->pengirim,
            'security' => $request->security,
            'diketahui' => $request->diketahui,
            'disetujui' => $request->disetujui,
            'diterima' => $request->diterima,
            'deleted_status' => false,
        ]);

        return redirect()->route('admin.surat_jalan.index');
    }

    public function edit(SuratJalan $suratJalan)
    {
        // Decode JSON menjadi array
        $items = json_decode($suratJalan->json, true);

        // Jika decoding gagal (kembalikan false), maka inisialisasi $items dengan array kosong
        if (!is_array($items)) {
            $items = [];
        }

        return view('admin.surat_jalan.edit', compact('suratJalan', 'items'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'no_po' => 'required|string|max:255',
            'no_spp' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
            'proyek' => 'required|string|max:255',
            'penerima' => 'required|string|max:255',
            'items' => 'required|array',
            'items.*.item' => 'required|string|max:255', // Validasi item
            'items.*.kode' => 'required|string|max:255', // Validasi kode
            'items.*.panjang' => 'required|numeric', // Validasi panjang
            'items.*.jumlah' => 'required|numeric', // Validasi jumlah
            'items.*.satuan' => 'required|string|max:50', // Validasi satuan
            'items.*.keterangan' => 'nullable|string|max:255', // Validasi keterangan
            'author' => 'required|exists:users,id',
            'pengirim' => 'required|string|max:255',
            'security' => 'required|string|max:255',
            'diketahui' => 'required|string|max:255',
            'disetujui' => 'required|string|max:255',
            'diterima' => 'required|string|max:255',
        ]);

        $suratJalan = SuratJalan::findOrFail($id);

        // Transform data items menjadi array yang terstruktur
        $items = [];
        foreach ($request->items as $item) {
            $items[] = [
                'item' => $item['item'] ?? null,
                'kode' => $item['kode'] ?? null,
                'panjang' => $item['panjang'] ?? null,
                'jumlah' => $item['jumlah'] ?? null,
                'satuan' => $item['satuan'] ?? null,
                'keterangan' => $item['keterangan'] ?? null,
            ];
        }

        // Update data Surat Jalan
        $suratJalan->update([
            'no_po' => $request->no_po,
            'no_spp' => $request->no_spp,
            'keterangan' => $request->keterangan,
            'tujuan' => $request->tujuan,
            'proyek' => $request->proyek,
            'penerima' => $request->penerima,
            'json' => json_encode($items), // Simpan items dalam format JSON yang terstruktur
            'author' => $request->author,
            'pengirim' => $request->pengirim,
            'security' => $request->security,
            'diketahui' => $request->diketahui,
            'disetujui' => $request->disetujui,
            'diterima' => $request->diterima,
        ]);

        return redirect()->route('admin.surat_jalan.index');
    }


    // Soft delete Surat Jalan (change deleted_status to true)
    public function destroy(SuratJalan $suratJalan)
    {
        $suratJalan->update(['deleted_status' => true]);
        return redirect()->route('admin.surat_jalan.index');
    }
}
