<?php

namespace App\Http\Controllers\Admin;

use App\Models\SyaratKetentuan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SyaratController extends Controller
{
    /**
     * Menampilkan daftar syarat ketentuan.
     */
    public function index()
    {
        // Mengambil hanya data dengan status_deleted = false
        $syaratKetentuan = SyaratKetentuan::where('status_deleted', 0)->get();
        
        return view('admin.syarat_ketentuan.index', compact('syaratKetentuan'));
    }

    /**
     * Menampilkan form untuk membuat syarat ketentuan baru.
     */
    public function create()
    {
        return view('admin.syarat_ketentuan.create');
    }

    /**
     * Menyimpan syarat ketentuan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'syarat' => 'required|string',
        ]);

        SyaratKetentuan::create($request->all());

        return redirect()->route('admin.syarat_ketentuan.index')
                         ->with('success', 'Syarat ketentuan berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit syarat ketentuan.
     */
    public function edit($id)
    {
        $syaratKetentuan = SyaratKetentuan::findOrFail($id);
        return view('admin.syarat_ketentuan.edit', compact('syaratKetentuan'));
    }

    /**
     * Memperbarui syarat ketentuan yang ada di database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'syarat' => 'required|string',
        ]);

        $syaratKetentuan = SyaratKetentuan::findOrFail($id);
        $syaratKetentuan->update($request->all());

        return redirect()->route('admin.syarat_ketentuan.index')
                         ->with('success', 'Syarat ketentuan berhasil diperbarui!');
    }

    /**
     * Menghapus syarat ketentuan dari database.
     */
    public function destroy($id)
    {
        $syaratKetentuan = SyaratKetentuan::findOrFail($id);
        $syaratKetentuan->delete();

        return redirect()->route('admin.syarat_ketentuan.index')
                         ->with('success', 'Syarat ketentuan berhasil dihapus!');
    }
}
