<?php

namespace App\Http\Controllers\Admin;

use App\Models\Aksesoris;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AksesorisController extends Controller
{
    public function index()
    {
        $aksesoris = Aksesoris::all();
        return view('admin.aksesoris.index', compact('aksesoris'));
    }

    public function create()
    {
        return view('admin.aksesoris.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'satuan' => 'required|string',
            'harga' => 'required|numeric',
            'status' => 'required|boolean',
        ]);

        Aksesoris::create($request->all());

        return redirect()->route('admin.aksesoris.index')
                         ->with('success', 'Aksesoris berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $aksesoris = Aksesoris::findOrFail($id);
        return view('admin.aksesoris.edit', compact('aksesoris'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|string',
            'satuan' => 'required|string',
            'harga' => 'required|numeric',
            'status' => 'required|string',
        ]);

        $aksesoris = Aksesoris::findOrFail($id);
        $aksesoris->update($request->all());

        return redirect()->route('admin.aksesoris.index')
                         ->with('success', 'Aksesoris berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $aksesoris = Aksesoris::findOrFail($id);
        $aksesoris->delete();

        return redirect()->route('admin.aksesoris.index')
                         ->with('success', 'Aksesoris berhasil dihapus!');
    }
}
