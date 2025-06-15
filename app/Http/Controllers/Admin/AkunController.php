<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class AkunController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('status_deleted', false)->latest()->paginate(10);
        return view('admin.akun.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.akun.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'profile' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'role' => ['required', 'integer', 'in:1,2,3,4'],
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $data['status_deleted'] = false;

        if ($request->hasFile('profile')) {
            $data['profile'] = $request->file('profile')->store('profiles', 'public');
        }

        User::create($data);

        return redirect()
            ->route('admin.akun.index')
            ->with('success', 'Akun berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $akun)
    {
        return view('admin.akun.edit', compact('akun'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $akun)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $akun->id],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'profile' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'role' => ['required', 'integer', 'in:1,2,3,4'],
        ]);

        $data = $request->except('password');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('profile')) {
            // Delete old profile if exists
            if ($akun->profile) {
                Storage::disk('public')->delete($akun->profile);
            }
            $data['profile'] = $request->file('profile')->store('profiles', 'public');
        }

        $akun->update($data);

        return redirect()
            ->route('admin.akun.index')
            ->with('success', 'Akun berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $akun)
    {
        // Don't allow deleting own account
        if ($akun->id === auth()->id()) {
            return redirect()
                ->route('admin.akun.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        // Soft delete by updating status_deleted
        $akun->update(['status_deleted' => true]);

        return redirect()
            ->route('admin.akun.index')
            ->with('success', 'Akun berhasil dihapus.');
    }
} 