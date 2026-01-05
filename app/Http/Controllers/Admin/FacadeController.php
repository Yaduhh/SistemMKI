<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FacadeController extends Controller
{
    /**
     * Display a listing of the facade records.
     */
    public function index()
    {
        $facades = Facade::active()->with('creator')->latest()->where('status_aksesoris', 0)->get();
        $aksesorisFacades = Facade::active()->with('creator')->latest()->where('status_aksesoris', 1)->get();
        return view('admin.facade.index', compact('facades', 'aksesorisFacades'));
    }

    /**
     * Show the form for creating a new facade record.
     */
    public function create()
    {
        return view('admin.facade.create');
    }

    /**
     * Store a newly created facade record.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255',
            'nama_produk' => 'nullable|string|max:255',
            'lebar' => 'required|numeric|min:0',
            'tebal' => 'required|numeric|min:0',
            'panjang' => 'required|numeric|min:0',
            'luas_btg' => 'required|numeric|min:0',
            'luas_m2' => 'required|numeric|min:0',
            'harga' => 'required|numeric|min:0',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['status_deleted'] = false;
        $validated['status_aksesoris'] = $request->has('status_aksesoris');
        $validated['slug'] = Str::slug($validated['code']);

        Facade::create($validated);

        return redirect()->route('admin.facade.index')
            ->with('success', 'Facade berhasil ditambahkan');
    }

    /**
     * Display the specified facade record.
     */
    public function show(Facade $facade)
    {
        return view('admin.facade.show', compact('facade'));
    }

    /**
     * Show the form for editing the specified facade record.
     */
    public function edit(Facade $facade)
    {
        return view('admin.facade.edit', compact('facade'));
    }

    /**
     * Update the specified facade record.
     */
    public function update(Request $request, Facade $facade)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255',
            'nama_produk' => 'nullable|string|max:255',
            'lebar' => 'required|numeric|min:0',
            'tebal' => 'required|numeric|min:0',
            'panjang' => 'required|numeric|min:0',
            'luas_btg' => 'required|numeric|min:0',
            'luas_m2' => 'required|numeric|min:0',
            'harga' => 'required|numeric|min:0',
        ]);

        $validated['status_aksesoris'] = $request->has('status_aksesoris');
        
        // Hanya update slug jika code berubah
        if ($facade->code !== $validated['code']) {
            $baseSlug = Str::slug($validated['code']);
            
            // Generate slug yang unique dengan counter
            $slug = $baseSlug;
            $counter = 1;
            
            // Cek apakah slug sudah ada di record lain
            while (Facade::where('slug', $slug)
                ->where('id', '!=', $facade->id)
                ->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            
            $validated['slug'] = $slug;
        }
        // Jika code tidak berubah, jangan update slug (biarkan slug yang lama)
        
        $facade->update($validated);

        return redirect()->route('admin.facade.index')
            ->with('success', 'Facade berhasil diperbarui');
    }

    /**
     * Remove the specified facade record (soft delete).
     */
    public function destroy(Facade $facade)
    {
        $facade->update(['status_deleted' => true]);
        
        return redirect()->route('admin.facade.index')
            ->with('success', 'Facade berhasil dihapus');
    }
} 