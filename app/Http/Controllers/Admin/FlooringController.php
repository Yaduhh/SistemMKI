<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Flooring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FlooringController extends Controller
{
    public function index()
    {
        $floorings = Flooring::with('creator')->active()->get();
        return view('admin.flooring.index', compact('floorings'));
    }

    public function create()
    {
        return view('admin.flooring.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255',
            'lebar' => 'required|numeric|min:0',
            'tebal' => 'required|numeric|min:0',
            'panjang' => 'required|numeric|min:0',
            'satuan' => 'required|in:mm,cm,m',
            'luas_btg' => 'required|numeric|min:0',
            'luas_m2' => 'required|numeric|min:0',
        ]);

        $validated['created_by'] = Auth::id();

        Flooring::create($validated);

        return redirect()->route('admin.flooring.index')
            ->with('success', 'Flooring berhasil ditambahkan.');
    }

    public function show(Flooring $flooring)
    {
        return view('admin.flooring.show', compact('flooring'));
    }

    public function edit(Flooring $flooring)
    {
        return view('admin.flooring.edit', compact('flooring'));
    }

    public function update(Request $request, Flooring $flooring)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255',
            'lebar' => 'required|numeric|min:0',
            'tebal' => 'required|numeric|min:0',
            'panjang' => 'required|numeric|min:0',
            'satuan' => 'required|in:mm,cm,m',
            'luas_btg' => 'required|numeric|min:0',
            'luas_m2' => 'required|numeric|min:0',
        ]);

        $flooring->update($validated);

        return redirect()->route('admin.flooring.index')
            ->with('success', 'Flooring berhasil diperbarui.');
    }

    public function destroy(Flooring $flooring)
    {
        $flooring->update(['status_deleted' => true]);

        return redirect()->route('admin.flooring.index')
            ->with('success', 'Flooring berhasil dihapus.');
    }
} 