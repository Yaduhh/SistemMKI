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
        $facades = Facade::active()->with('creator')->latest()->get();
        return view('admin.facade.index', compact('facades'));
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
            'code' => 'required|string|max:255|unique:facade',
            'lebar' => 'required|numeric|min:0',
            'tebal' => 'required|numeric|min:0',
            'panjang' => 'required|numeric|min:0',
            'luas_btg' => 'required|numeric|min:0',
            'luas_m2' => 'required|numeric|min:0',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['status_deleted'] = false;
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
            'code' => 'required|string|max:255|unique:facade,code,' . $facade->id,
            'lebar' => 'required|numeric|min:0',
            'tebal' => 'required|numeric|min:0',
            'panjang' => 'required|numeric|min:0',
            'luas_btg' => 'required|numeric|min:0',
            'luas_m2' => 'required|numeric|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['code']);
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