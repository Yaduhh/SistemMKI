<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TandaTangan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TandaTanganController extends Controller
{
    public function index()
    {
        $tandaTangan = TandaTangan::with('user')->get();
        $users = User::whereDoesntHave('tandaTangan')->get();
        
        return view('admin.tanda-tangan.index', compact('tandaTangan', 'users'));
    }

    public function create()
    {
        $users = User::whereDoesntHave('tandaTangan')->get();
        return view('admin.tanda-tangan.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id|unique:tanda_tangan,id_user',
            'ttd' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $path = $request->file('ttd')->store('tanda-tangan', 'public');
            
            TandaTangan::create([
                'id_user' => $request->id_user,
                'ttd' => $path
            ]);

            return redirect()->route('admin.tanda-tangan.index')
                ->with('success', 'Tanda tangan berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $tandaTangan = TandaTangan::with('user')->findOrFail($id);
        return view('admin.tanda-tangan.edit', compact('tandaTangan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ttd' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $tandaTangan = TandaTangan::findOrFail($id);
            
            // Hapus file lama
            if ($tandaTangan->ttd && Storage::disk('public')->exists($tandaTangan->ttd)) {
                Storage::disk('public')->delete($tandaTangan->ttd);
            }
            
            // Upload file baru
            $path = $request->file('ttd')->store('tanda-tangan', 'public');
            
            $tandaTangan->update(['ttd' => $path]);

            return redirect()->route('admin.tanda-tangan.index')
                ->with('success', 'Tanda tangan berhasil diupdate');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $tandaTangan = TandaTangan::findOrFail($id);
            
            // Hapus file
            if ($tandaTangan->ttd && Storage::disk('public')->exists($tandaTangan->ttd)) {
                Storage::disk('public')->delete($tandaTangan->ttd);
            }
            
            $tandaTangan->delete();

            return redirect()->route('admin.tanda-tangan.index')
                ->with('success', 'Tanda tangan berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
