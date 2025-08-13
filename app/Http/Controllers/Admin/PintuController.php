<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pintu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PintuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pintus = Pintu::where('status_aksesoris', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        $aksesorisPintus = Pintu::where('status_aksesoris', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.pintu.index', compact('pintus', 'aksesorisPintus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pintu.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:pintu',
            'nama_produk' => 'required|string|max:255',
            'lebar' => 'nullable|numeric|min:0',
            'tebal' => 'nullable|numeric|min:0',
            'tinggi' => 'nullable|numeric|min:0',
            'warna' => 'nullable|string|max:255',
            'harga_satuan' => 'required|numeric|min:0',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['status_aksesoris'] = $request->has('status_aksesoris');

        Pintu::create($validated);

        return redirect()->route('admin.pintu.index')
            ->with('success', 'Pintu berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pintu = Pintu::findOrFail($id);
        return view('admin.pintu.show', compact('pintu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pintu = Pintu::findOrFail($id);
        return view('admin.pintu.edit', compact('pintu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pintu = Pintu::findOrFail($id);
        
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:pintu,code,' . $id,
            'nama_produk' => 'required|string|max:255',
            'lebar' => 'nullable|numeric|min:0',
            'tebal' => 'nullable|numeric|min:0',
            'tinggi' => 'nullable|numeric|min:0',
            'warna' => 'nullable|string|max:255',
            'harga_satuan' => 'required|numeric|min:0',
        ]);

        $validated['status_aksesoris'] = $request->has('status_aksesoris');
        $pintu->update($validated);

        return redirect()->route('admin.pintu.index')
            ->with('success', 'Pintu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pintu = Pintu::findOrFail($id);
        $pintu->update(['status_deleted' => true]);

        return redirect()->route('admin.pintu.index')
            ->with('success', 'Pintu berhasil dihapus');
    }
}
