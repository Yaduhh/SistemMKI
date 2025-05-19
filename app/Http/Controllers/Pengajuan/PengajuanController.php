<?php

namespace App\Http\Controllers\Pengajuan;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\Produk;
use App\Models\Aksesoris;
use App\Models\SyaratKetentuan;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
      // Tampilkan daftar pengajuan
    public function index()
    {
        $pengajuan = Pengajuan::latest()->paginate(10);
        return view('pengajuan.index', compact('pengajuan'));
    }

    public function create()
    {
        // Ambil semua produk dan aksesoris
        $produk = Produk::where('status_deleted', 0)->get();
        $syarat = SyaratKetentuan::where('status_deleted', 0)->get();
        $aksesoris = Aksesoris::where('status_deleted', 0)->get();
        return view('pengajuan.create', compact('produk', 'syarat', 'aksesoris'));
    }

     public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'judul_pengajuan' => 'required|string',
            'json_produk'     => 'required|array', // Validasi bahwa json_produk adalah array
            'diskon_satu'     => 'nullable|integer',
            'diskon_dua'      => 'nullable|integer',
            'diskon_tiga'     => 'nullable|integer',
            'status'          => 'nullable|boolean',
        ]);

        // Menyimpan data pengajuan baru
        Pengajuan::create([
            'judul_pengajuan' => $validated['judul_pengajuan'],
            'json_produk'     => json_encode($validated['json_produk']), // Mengonversi array produk menjadi JSON
            'diskon_satu'     => $validated['diskon_satu'] ?? 0,
            'diskon_dua'      => $validated['diskon_dua'] ?? 0,
            'diskon_tiga'     => $validated['diskon_tiga'] ?? 0,
            'status'          => $validated['status'] ?? 0,
        ]);

        return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan berhasil ditambahkan.');
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

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil diupdate.');
    }

    // Hapus data
    public function destroy(Pengajuan $pengajuan)
    {
        $pengajuan->delete();
        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil dihapus.');
    }
}
