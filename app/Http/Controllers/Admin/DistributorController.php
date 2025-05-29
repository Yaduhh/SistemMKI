<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DistributorController extends Controller
{
    public function index()
    {
        $distributors = Distributor::all();
        return view('admin.distributor.index', compact('distributors'));
    }

    public function create()
    {
        return view('admin.distributor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_distributor' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'boolean'
        ]);

        $data = $request->all();

        if ($request->hasFile('profile')) {
            $profile = $request->file('profile');
            $profilePath = $profile->store('distributor-profiles', 'public');
            $data['profile'] = $profilePath;
        }

        Distributor::create($data);

        return redirect()->route('admin.distributor.index')
            ->with('success', 'Distributor berhasil ditambahkan');
    }

    public function edit(Distributor $distributor)
    {
        return view('admin.distributor.edit', compact('distributor'));
    }

    public function update(Request $request, Distributor $distributor)
    {
        $request->validate([
            'nama_distributor' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'boolean'
        ]);

        $data = $request->all();

        if ($request->hasFile('profile')) {
            // Delete old profile if exists
            if ($distributor->profile) {
                Storage::disk('public')->delete($distributor->profile);
            }
            
            $profile = $request->file('profile');
            $profilePath = $profile->store('distributor-profiles', 'public');
            $data['profile'] = $profilePath;
        }

        $distributor->update($data);

        return redirect()->route('admin.distributor.index')
            ->with('success', 'Distributor berhasil diperbarui');
    }

    public function destroy(Distributor $distributor)
    {
        $distributor->delete();
        
        return redirect()->route('admin.distributor.index')
            ->with('success', 'Distributor berhasil dihapus');
    }
} 