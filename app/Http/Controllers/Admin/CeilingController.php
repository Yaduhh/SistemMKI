<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ceiling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CeilingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ceilings = Ceiling::where('status_deleted', false)
            ->where('status_aksesoris', 0)
            ->orderBy('created_at', 'desc')
            ->get();
        
        $aksesorisCeilings = Ceiling::where('status_deleted', false)
            ->where('status_aksesoris', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.ceiling.index', compact('ceilings', 'aksesorisCeilings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.ceiling.create');
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

        Ceiling::create($validated);

        return redirect()->route('admin.ceiling.index')
            ->with('success', 'Ceiling berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ceiling $ceiling)
    {
        return view('admin.ceiling.show', compact('ceiling'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ceiling $ceiling)
    {
        return view('admin.ceiling.edit', compact('ceiling'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ceiling $ceiling)
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
        $ceiling->update($validated);

        return redirect()->route('admin.ceiling.index')
            ->with('success', 'Ceiling berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ceiling $ceiling)
    {
        $ceiling->update(['status_deleted' => true]);

        return redirect()->route('admin.ceiling.index')
            ->with('success', 'Ceiling berhasil dihapus');
    }
} 