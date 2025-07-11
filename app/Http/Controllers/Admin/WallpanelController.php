<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wallpanel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class WallpanelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wallpanels = Wallpanel::where('status_deleted', false)
            ->where('status_aksesoris', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        $aksesorisWallpanels = Wallpanel::where('status_deleted', false)
            ->where('status_aksesoris', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.wallpanel.index', compact('wallpanels', 'aksesorisWallpanels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.wallpanel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255',
            'nama_produk' => 'nullable|string|max:255',
            'lebar' => 'required|numeric|min:0',
            'tebal' => 'required|numeric|min:0',
            'panjang' => 'required|numeric|min:0',
            'satuan' => 'required|in:mm,cm,m',
            'luas_btg' => 'required|numeric|min:0',
            'luas_m2' => 'required|numeric|min:0',
            'harga' => 'required|numeric|min:0',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['status_aksesoris'] = $request->has('status_aksesoris');

        Wallpanel::create($validated);

        return redirect()->route('admin.wallpanel.index')
            ->with('success', 'Wallpanel berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Wallpanel $wallpanel)
    {
        return view('admin.wallpanel.show', compact('wallpanel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wallpanel $wallpanel)
    {
        return view('admin.wallpanel.edit', compact('wallpanel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wallpanel $wallpanel)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255',
            'nama_produk' => 'nullable|string|max:255',
            'lebar' => 'required|numeric|min:0',
            'tebal' => 'required|numeric|min:0',
            'panjang' => 'required|numeric|min:0',
            'satuan' => 'required|in:mm,cm,m',
            'luas_btg' => 'required|numeric|min:0',
            'luas_m2' => 'required|numeric|min:0',
            'harga' => 'required|numeric|min:0',
        ]);

        $validated['status_aksesoris'] = $request->has('status_aksesoris');
        $wallpanel->update($validated);

        return redirect()->route('admin.wallpanel.index')
            ->with('success', 'Wallpanel berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wallpanel $wallpanel)
    {
        $wallpanel->update(['status_deleted' => true]);

        return redirect()->route('admin.wallpanel.index')
            ->with('success', 'Wallpanel berhasil dihapus');
    }
} 