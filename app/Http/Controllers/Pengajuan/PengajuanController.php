<?php

namespace App\Http\Controllers\Pengajuan;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\Produk;
use App\Models\User;
use App\Models\Aksesoris;
use App\Models\SyaratKetentuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;


class PengajuanController extends Controller
{
    public function cetak(Request $request, $id)
    {
        // Ambil data pengajuan berdasarkan ID
        $pengajuan = Pengajuan::findOrFail($id);
        // Decode JSON fields to arrays
        $json_produk = json_decode($pengajuan->json_produk, true);
        $json_aksesoris = json_decode($pengajuan->json_aksesoris, true);
        $json_syarat_ketentuan = json_decode($pengajuan->syarat_kondisi, true);

        $pdf = PDF::loadView('pengajuan.pdf_item', compact('pengajuan', 'json_produk', 'json_aksesoris', 'json_syarat_ketentuan'));

        // Sanitize the filename to remove illegal characters
        $safeFilename = str_replace(['/', '\\'], '-', $pengajuan->nomor_pengajuan);
        
        // Download file PDF with sanitized filename
        return $pdf->download('pengajuan_' . $safeFilename . '.pdf');
    }
        
    public function index()
    {
        $pengajuan = Pengajuan::latest()->paginate(10);
        return view('pengajuan.index', compact('pengajuan'));
    }

    public function create()
    {
        // Ambil semua produk dan aksesoris
        $users = User::where('status_deleted', 0)->get();
        $produk = Produk::where('status_deleted', 0)->get();
        $syarats = SyaratKetentuan::where('status_deleted', 0)->get();
        $aksesoris = Aksesoris::where('status_deleted', 0)->get();
        return view('pengajuan.create', compact('produk', 'syarats', 'aksesoris', 'users'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'judul_pengajuan' => 'required|string',
            'json_produk'     => 'required|string',
            'json_aksesoris'  => 'required|string',
            'syarat_kondisi' => 'nullable|array',
            'diskon_satu'     => 'nullable|integer',
            'diskon_dua'      => 'nullable|integer',
            'diskon_tiga'     => 'nullable|integer',
            'ppn'             => 'nullable|integer',
            'note'            => 'required|string',
            'client'          => 'required|string',
            'nama_client'     => 'required|string',
            'title_produk'    => 'required|string',
            'title_aksesoris' => 'required|string',
            'id_user'         => 'required|exists:users,id',
        ]);

        // Pastikan data JSON diterima dengan benar
         // Ambil nilai id_user yang dipilih dari form
        $id_user = $validated['id_user'];
        $jsonProduk = json_decode($request->json_produk, true);
        $jsonAksesoris = json_decode($request->json_aksesoris, true);
        $jsonSyaratKondisi = $request->has('syarat_kondisi') ? json_encode($request->syarat_kondisi) : null;

        // Cek apakah JSON berhasil didekode
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Format JSON tidak valid'], 400);
        }

        // Pastikan bahwa $jsonProduk adalah array
        if (!is_array($jsonProduk)) {
            return response()->json(['error' => 'Data produk tidak valid'], 400);
        }

        if (!is_array($jsonAksesoris)) {
            return response()->json(['error' => 'Data aksesoris tidak valid'], 400);
        }
            // Mengambil nomor pengajuan terakhir
        $lastPengajuan = Pengajuan::latest()->first();
        $lastNumber = $lastPengajuan ? $lastPengajuan->nomor_pengajuan : null;

        // Ambil bulan dan tahun saat ini
        $month = date('m');
        $year = date('y');

        // Format nomor pengajuan
        $prefix = 'A/MK/' . $month . '/' . $year;
        $number = $lastNumber ? (int)substr($lastNumber, 0, 2) + 1 : 1;
        $nomor_pengajuan = str_pad($number, 2, '0', STR_PAD_LEFT) . $prefix;


        // Hitung total harga produk dan aksesoris
        $total_1 = 0;
        foreach ($jsonProduk as $produk) {
            $produkModel = Produk::find($produk['id']);
            if ($produkModel) {
                $total_1 += $produkModel->harga * ($produk['quantity'] ?? 1);
            }
        }

        $total_2 = 0;
        foreach ($jsonAksesoris as $aksesoris) {
            $aksesorisModel = Aksesoris::find($aksesoris['id']);
            if ($aksesorisModel) {
                $total_2 += $aksesorisModel->harga * ($aksesoris['quantity'] ?? 1);
            }
        }

        // Hitung PPN dan grand total
        $ppn = $validated['ppn'] ?? 0;
        $ppn_value = ($total_1 + $total_2) * ($ppn / 100);
        $grand_total = $total_1 + $total_2 + $ppn_value;
        // Logika untuk menyimpan pengajuan
        try {
            Pengajuan::create([
                'id_user' => $id_user,
                'nomor_pengajuan' => $nomor_pengajuan,  // Pastikan variabel ini sudah didefinisikan
                'judul_pengajuan' => $validated['judul_pengajuan'],
                'json_produk'     => $validated['json_produk'],
                'json_aksesoris'  => $validated['json_aksesoris'],
                'syarat_kondisi'  => $jsonSyaratKondisi,
                'diskon_satu'     => $validated['diskon_satu'] ?? 0,
                'diskon_dua'      => $validated['diskon_dua'] ?? 0,
                'diskon_tiga'     => $validated['diskon_tiga'] ?? 0,
                'status'          => 0,
                'date_pengajuan'  => now(),
                'total_1'         => $total_1,
                'total_2'         => $total_2,
                'ppn'             => $ppn,
                'note'            => $validated['note'],
                'grand_total'     => $grand_total,
                'client'          => $validated['client'],
                'nama_client'     => $validated['nama_client'],
                'title_produk'    => $validated['title_produk'],
                'title_aksesoris' => $validated['title_aksesoris'],
                'status_deleted'  => 0,
            ]);

            return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan berhasil disimpan.');
        } catch (\Exception $e) {
            \Log::error('Gagal menyimpan pengajuan: ' . $e->getMessage());
            return redirect()->route('admin.pengajuan.index')->with('error', 'Gagal Menyimpan.');
        }
    }

    // Tampilkan form edit
    public function edit(Pengajuan $pengajuan)
    {
        return view('pengajuan.edit', compact('pengajuan'));
    }

    // Update data
    public function update(Request $request, Pengajuan $pengajuan)
    {
        $validated = $request->validate([
            'id_user'         => 'nullable|exists:users,id',
            'nomor_pengajuan' => 'nullable|string',
            'date_pengajuan'  => 'nullable|date',
            'judul_pengajuan' => 'nullable|string',
            'diskon_satu'     => 'nullable|integer',
            'diskon_dua'      => 'nullable|integer',
            'diskon_tiga'     => 'nullable|integer',
            'client'          => 'nullable|string',
            'nama_client'     => 'nullable|string',
            'title_produk'    => 'nullable|string',
            'title_aksesoris' => 'nullable|string',
            'json_produk'     => 'nullable|string',
            'total_1'         => 'nullable|numeric',
            'total_2'         => 'nullable|numeric',
            'note'            => 'nullable|string',
            'ppn'             => 'nullable|integer',
            'grand_total'     => 'nullable|numeric',
            'syarat_kondisi'  => 'nullable|string',
            'status'          => 'nullable|integer',
            'status_deleted'  => 'nullable|boolean',
        ]);

        $pengajuan->update($validated);

        return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan berhasil diupdate.');
    }

    // Hapus data
    public function destroy(Pengajuan $pengajuan)
    {
        $pengajuan->delete();
        return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan berhasil dihapus.');
    }
}
