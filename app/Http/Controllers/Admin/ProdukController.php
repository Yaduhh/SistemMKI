<?php

namespace App\Http\Controllers\Admin;

use App\Models\Produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProdukController extends Controller
{
    // Construct to check if user has role 1 (User role)
    public function __construct()
    {
        
    }

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
        ]);

        Produk::create($request->all());

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
        ]);

        $produk = Produk::findOrFail($id);
        $produk->update($request->all());

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui');
    }

    // Hapus Produk - Menangani penghapusan produk
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus');
    }
}
