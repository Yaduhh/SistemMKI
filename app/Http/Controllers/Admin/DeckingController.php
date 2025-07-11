<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Decking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeckingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deckings = Decking::active()->latest()->where('status_aksesoris', 0)->get();
        $aksesorisDeckings = Decking::active()->latest()->where('status_aksesoris', 1)->get();
        return view('admin.decking.index', compact('deckings', 'aksesorisDeckings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.decking.create');
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
        $validated['status_deleted'] = false;
        $validated['status_aksesoris'] = $request->has('status_aksesoris');

        Decking::create($validated);

        return redirect()->route('admin.decking.index')
            ->with('success', 'Decking berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Decking $decking)
    {
        return view('admin.decking.show', compact('decking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Decking $decking)
    {
        return view('admin.decking.edit', compact('decking'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Decking $decking)
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

        $decking->update($validated);

        return redirect()->route('admin.decking.index')
            ->with('success', 'Decking berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Decking $decking)
    {
        $decking->update(['status_deleted' => true]);
        
        return redirect()->route('admin.decking.index')
            ->with('success', 'Decking deleted successfully.');
    }
} 