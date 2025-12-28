<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RotanSintetis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RotanSintetisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rotanSintetis = RotanSintetis::where('status_deleted', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.rotan-sintetis.index', compact('rotanSintetis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.rotan-sintetis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255',
            'nama_produk' => 'required|string|max:255',
            'satuan' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);

        $validated['created_by'] = Auth::id();

        RotanSintetis::create($validated);

        return redirect()->route('admin.rotan-sintetis.index')
            ->with('success', 'Rotan Sintetis berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RotanSintetis $rotanSintetis)
    {
        return view('admin.rotan-sintetis.show', compact('rotanSintetis'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RotanSintetis $rotanSintetis)
    {
        return view('admin.rotan-sintetis.edit', compact('rotanSintetis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RotanSintetis $rotanSintetis)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255',
            'nama_produk' => 'required|string|max:255',
            'satuan' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);

        $rotanSintetis->update($validated);

        return redirect()->route('admin.rotan-sintetis.index')
            ->with('success', 'Rotan Sintetis berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RotanSintetis $rotanSintetis)
    {
        $rotanSintetis->update(['status_deleted' => true]);

        return redirect()->route('admin.rotan-sintetis.index')
            ->with('success', 'Rotan Sintetis berhasil dihapus');
    }
}
