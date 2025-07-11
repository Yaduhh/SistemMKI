<?php

namespace App\Http\Controllers\Admin;

use App\Models\SyaratPemasangan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SyaratPemasanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $syaratPemasangan = SyaratPemasangan::active()->get();
        return view('admin.syarat_pemasangan.index', compact('syaratPemasangan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.syarat_pemasangan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'syarat' => 'required|string',
        ]);

        SyaratPemasangan::create([
            'syarat' => $request->syarat,
            'status_deleted' => false,
        ]);

        return redirect()->route('admin.syarat-pemasangan.index')
                         ->with('success', 'Syarat pemasangan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $syaratPemasangan = SyaratPemasangan::findOrFail($id);
        return view('admin.syarat_pemasangan.show', compact('syaratPemasangan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $syaratPemasangan = SyaratPemasangan::findOrFail($id);
        return view('admin.syarat_pemasangan.edit', compact('syaratPemasangan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'syarat' => 'required|string',
        ]);

        $syaratPemasangan = SyaratPemasangan::findOrFail($id);
        $syaratPemasangan->update([
            'syarat' => $request->syarat,
        ]);

        return redirect()->route('admin.syarat-pemasangan.index')
                         ->with('success', 'Syarat pemasangan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $syaratPemasangan = SyaratPemasangan::findOrFail($id);
        $syaratPemasangan->update(['status_deleted' => true]);

        return redirect()->route('admin.syarat-pemasangan.index')
                         ->with('success', 'Syarat pemasangan berhasil dihapus!');
    }
}
