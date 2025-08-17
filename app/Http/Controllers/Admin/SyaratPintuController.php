<?php

namespace App\Http\Controllers\Admin;

use App\Models\SyaratKetentuan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SyaratPintuController extends Controller
{
    /**
     * Menampilkan daftar syarat pintu.
     */
    public function index()
    {
        // Mengambil hanya data dengan status_deleted = false dan syarat_pintu = 1
        $syaratPintu = SyaratKetentuan::where('status_deleted', 0)
                                      ->where('syarat_pintu', 1)
                                      ->get();
        
        return view('admin.syarat_pintu.index', compact('syaratPintu'));
    }

    /**
     * Menampilkan form untuk membuat syarat pintu baru.
     */
    public function create()
    {
        return view('admin.syarat_pintu.create');
    }

    /**
     * Menyimpan syarat pintu baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'syarat' => 'required|string',
        ]);

        SyaratKetentuan::create([
            'syarat' => $request->syarat,
            'syarat_pintu' => 1,
            'status_deleted' => 0,
        ]);

        return redirect()->route('admin.syarat-pintu.index')
                         ->with('success', 'Syarat pintu berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit syarat pintu.
     */
    public function edit($id)
    {
        $syaratPintu = SyaratKetentuan::where('id', $id)
                                      ->where('syarat_pintu', 1)
                                      ->firstOrFail();
        return view('admin.syarat_pintu.edit', compact('syaratPintu'));
    }

    /**
     * Memperbarui syarat pintu yang ada di database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'syarat' => 'required|string',
        ]);

        $syaratPintu = SyaratKetentuan::where('id', $id)
                                      ->where('syarat_pintu', 1)
                                      ->firstOrFail();
        $syaratPintu->update([
            'syarat' => $request->syarat,
        ]);

        return redirect()->route('admin.syarat-pintu.index')
                         ->with('success', 'Syarat pintu berhasil diperbarui!');
    }

    /**
     * Menghapus syarat pintu dari database.
     */
    public function destroy($id)
    {
        $syaratPintu = SyaratKetentuan::where('id', $id)
                                      ->where('syarat_pintu', 1)
                                      ->firstOrFail();
        
        // Soft delete dengan mengubah status_deleted menjadi true
        $syaratPintu->update(['status_deleted' => 1]);

        return redirect()->route('admin.syarat-pintu.index')
                         ->with('success', 'Syarat pintu berhasil dihapus!');
    }
}
