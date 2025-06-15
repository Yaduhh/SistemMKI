<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Storage as FacadesStorage;
use App\Services\ActivityLogService;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Client::with('creator')
            ->where('status_deleted', false);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('notelp', 'like', "%{$search}%")
                  ->orWhere('nama_perusahaan', 'like', "%{$search}%")
                  ->orWhere('description_json', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Created by filter
        if ($request->filled('created_by')) {
            $query->where('created_by', $request->created_by);
        }

        $clients = $query->latest()->paginate(12);

        // Get unique creators for filter
        $creators = Client::with('creator')
            ->get()
            ->pluck('creator')
            ->unique('id')
            ->filter();

        return view('admin.client.index', compact('clients', 'creators'));
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
            'email' => 'nullable|email|max:255',
            'notelp' => 'required|string|max:20',
            'nama_perusahaan' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'descriptions' => 'required|array|min:1',
            'descriptions.*' => 'required|string|max:255',
            'file_input' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'status' => 'boolean',
        ]);

        $data = $request->all();
        $data['created_by'] = Auth::id();
        $data['status'] = $request->has('status') ? true : false;
        $data['status_deleted'] = false;

        // Convert descriptions array to JSON
        $data['description_json'] = json_encode(['items' => $request->descriptions]);

        if ($request->hasFile('file_input')) {
            $data['file_input'] = $request->file('file_input')->store('clients', 'public');
        }

        $client = Client::create($data);

        // Log activity for client creation
        ActivityLogService::log(
            'create',
            'Client',
            "Sales menambahkan client baru: {$client->nama}",
            [],
            $client->toArray()
        );

        return redirect()
            ->route('admin.client.index')
            ->with('success', 'Client berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return view('admin.client.show', compact('client'));
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
            'nama_perusahaan' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'descriptions' => 'required|array|min:1',
            'descriptions.*' => 'required|string|max:255',
            'file_input' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'status' => 'boolean',
        ]);

        // Store old data for comparison
        $oldData = $client->toArray();

        $data = $request->all();
        $data['status'] = $request->has('status') ? true : false;

        // Convert descriptions array to JSON
        $data['description_json'] = json_encode(['items' => $request->descriptions]);

        if ($request->hasFile('file_input')) {
            // Delete old file if exists
            if ($client->file_input) {
                Storage::disk('public')->delete($client->file_input);
            }
            $data['file_input'] = $request->file('file_input')->store('clients', 'public');
        }

        $client->update($data);

        // Log activity for client update
        ActivityLogService::logUpdate(
            'Client',
            "Sales mengupdate client: {$client->nama}",
            $oldData,
            $client->fresh()->toArray()
        );

        return redirect()
            ->route('admin.client.index')
            ->with('success', 'Client berhasil diperbarui.');
    }

    /**
     * Soft delete the specified resource.
     */
    public function destroy(Client $client)
    {

        // Store old data for logging
        $oldData = $client->toArray();

        // Soft delete by setting status_deleted to true
        $client->update(['status_deleted' => true]);

        // Log activity for client deletion
        ActivityLogService::log(
            'delete',
            'Client',
            "Sales menghapus client: {$client->nama}",
            $oldData,
            ['status_deleted' => true]
        );

        return redirect()
            ->route('admin.client.index')
            ->with('success', 'Client berhasil dihapus.');
    }

    /**
     * Download client file.
     */
    public function download(Client $client)
    {
        if (!$client->file_path || !Storage::exists($client->file_path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::download($client->file_path);
    }
}