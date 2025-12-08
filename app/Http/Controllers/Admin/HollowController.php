<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hollow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HollowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hollows = Hollow::where('status_deleted', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.hollow.index', compact('hollows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.hollow.create');
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

        Hollow::create($validated);

        return redirect()->route('admin.hollow.index')
            ->with('success', 'Hollow berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Hollow $hollow)
    {
        return view('admin.hollow.show', compact('hollow'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hollow $hollow)
    {
        return view('admin.hollow.edit', compact('hollow'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hollow $hollow)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255',
            'nama_produk' => 'required|string|max:255',
            'satuan' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);

        $hollow->update($validated);

        return redirect()->route('admin.hollow.index')
            ->with('success', 'Hollow berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hollow $hollow)
    {
        $hollow->update(['status_deleted' => true]);

        return redirect()->route('admin.hollow.index')
            ->with('success', 'Hollow berhasil dihapus');
    }
}
