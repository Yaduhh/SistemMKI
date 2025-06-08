<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ceiling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CeilingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ceilings = Ceiling::where('status_deleted', false)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.ceiling.index', compact('ceilings'));
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
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:255',
            'lebar' => 'required|numeric',
            'tebal' => 'required|numeric',
            'panjang' => 'required|numeric',
            'luas_btg' => 'required|numeric',
            'luas_m2' => 'required|numeric',
            'satuan' => 'required|in:mm,cm,m',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $ceiling = Ceiling::create([
            'code' => $request->code,
            'lebar' => $request->lebar,
            'tebal' => $request->tebal,
            'panjang' => $request->panjang,
            'luas_btg' => $request->luas_btg,
            'luas_m2' => $request->luas_m2,
            'satuan' => $request->satuan,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.ceiling.index')
            ->with('success', 'Ceiling berhasil ditambahkan');
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
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:255',
            'lebar' => 'required|numeric',
            'tebal' => 'required|numeric',
            'panjang' => 'required|numeric',
            'luas_btg' => 'required|numeric',
            'luas_m2' => 'required|numeric',
            'satuan' => 'required|in:mm,cm,m',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $ceiling->update([
            'code' => $request->code,
            'lebar' => $request->lebar,
            'tebal' => $request->tebal,
            'panjang' => $request->panjang,
            'luas_btg' => $request->luas_btg,
            'luas_m2' => $request->luas_m2,
            'satuan' => $request->satuan,
        ]);

        return redirect()->route('admin.ceiling.index')
            ->with('success', 'Ceiling berhasil diperbarui');
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