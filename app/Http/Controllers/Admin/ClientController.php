<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::with('creator')
            ->latest()
            ->paginate(10);

        return view('admin.client.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.client.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'notelp' => 'required|string|max:20',
            'description' => 'nullable|string',
            'file_input' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'status' => 'boolean',
        ]);

        $data = $request->all();
        $data['created_by'] = Auth::id();

        if ($request->hasFile('file_input')) {
            $data['file_input'] = $request->file('file_input')->store('clients', 'public');
        }

        Client::create($data);

        return redirect()
            ->route('admin.client.index')
            ->with('success', 'Client berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('admin.client.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'notelp' => 'required|string|max:20',
            'description' => 'nullable|string',
            'file_input' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'status' => 'boolean',
        ]);

        $data = $request->all();

        if ($request->hasFile('file_input')) {
            // Delete old file if exists
            if ($client->file_input) {
                Storage::disk('public')->delete($client->file_input);
            }
            $data['file_input'] = $request->file('file_input')->store('clients', 'public');
        }

        $client->update($data);

        return redirect()
            ->route('admin.client.index')
            ->with('success', 'Client berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()
            ->route('admin.client.index')
            ->with('success', 'Client berhasil dihapus.');
    }
} 