<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wallpanel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WallpanelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wallpanels = Wallpanel::where('status_deleted', false)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.wallpanels.index', compact('wallpanels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.wallpanels.create');
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

        $wallpanel = Wallpanel::create([
            'code' => $request->code,
            'lebar' => $request->lebar,
            'tebal' => $request->tebal,
            'panjang' => $request->panjang,
            'luas_btg' => $request->luas_btg,
            'luas_m2' => $request->luas_m2,
            'satuan' => $request->satuan,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.wallpanels.index')
            ->with('success', 'Wallpanel berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Wallpanel $wallpanel)
    {
        return view('admin.wallpanels.show', compact('wallpanel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wallpanel $wallpanel)
    {
        return view('admin.wallpanels.edit', compact('wallpanel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wallpanel $wallpanel)
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

        $wallpanel->update([
            'code' => $request->code,
            'lebar' => $request->lebar,
            'tebal' => $request->tebal,
            'panjang' => $request->panjang,
            'luas_btg' => $request->luas_btg,
            'luas_m2' => $request->luas_m2,
            'satuan' => $request->satuan,
        ]);

        return redirect()->route('admin.wallpanels.index')
            ->with('success', 'Wallpanel berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wallpanel $wallpanel)
    {
        $wallpanel->update(['status_deleted' => true]);

        return redirect()->route('admin.wallpanels.index')
            ->with('success', 'Wallpanel berhasil dihapus');
    }
} 