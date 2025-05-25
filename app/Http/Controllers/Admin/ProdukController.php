<?php

namespace App\Http\Controllers\Admin;

use App\Models\Produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    // Index Page - Menampilkan semua produk
    public function index()
    {
        $produks = Produk::all();
        return view('admin.produk.index', compact('produks'));
    }

    // Create Page - Menampilkan form untuk tambah produk
    public function create()
    {
        return view('admin.produk.create');
    }

    // Store Produk - Menyimpan produk baru ke dalam database
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'dimensi_lebar' => 'required|numeric',
            'dimensi_tinggi' => 'nullable|numeric',
            'panjang' => 'required|numeric',
            'warna' => 'required|string',
            'harga' => 'required|numeric',
            'nama_produk' => 'required|string|max:255', // Validasi untuk nama_produk
            'image_produk' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk image_produk
        ]);

        // Proses upload gambar
        if ($request->hasFile('image_produk')) {
            $imagePath = $request->file('image_produk')->store('produk_images', 'public');
        }

        // Simpan produk ke dalam database
        Produk::create([
            'type' => $request->type,
            'dimensi_lebar' => $request->dimensi_lebar,
            'dimensi_tinggi' => $request->dimensi_tinggi,
            'panjang' => $request->panjang,
            'warna' => $request->warna,
            'harga' => $request->harga,
            'nama_produk' => $request->nama_produk,
            'image_produk' => isset($imagePath) ? $imagePath : null, // Menyimpan path gambar
            'status_deleted' => false, // Status default (aktif)
        ]);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan');
    }

    // Edit Page - Menampilkan form untuk edit produk
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('admin.produk.edit', compact('produk'));
    }

    // Update Produk - Update produk yang sudah ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|string',
            'dimensi_lebar' => 'required|numeric',
            'dimensi_tinggi' => 'nullable|numeric',
            'panjang' => 'required|numeric',
            'warna' => 'required|string',
            'harga' => 'required|numeric',
            'nama_produk' => 'required|string|max:255', // Validasi untuk nama_produk
            'image_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk image_produk (opsional)
        ]);

        $produk = Produk::findOrFail($id);

        // Proses upload gambar jika ada file baru
        if ($request->hasFile('image_produk')) {
            // Hapus gambar lama jika ada
            if ($produk->image_produk) {
                Storage::delete('public/' . $produk->image_produk);
            }

            // Upload gambar baru
            $imagePath = $request->file('image_produk')->store('produk_images', 'public');
            $produk->image_produk = $imagePath;
        }

        // Update produk
        $produk->update([
            'type' => $request->type,
            'dimensi_lebar' => $request->dimensi_lebar,
            'dimensi_tinggi' => $request->dimensi_tinggi,
            'panjang' => $request->panjang,
            'warna' => $request->warna,
            'harga' => $request->harga,
            'nama_produk' => $request->nama_produk,
            'status_deleted' => false, // Update status
        ]);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui');
    }

    // Hapus Produk - Menangani penghapusan produk
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        
        // Hapus gambar jika ada
        if ($produk->image_produk) {
            Storage::delete('public/' . $produk->image_produk);
        }

        $produk->delete();

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus');
    }
}
