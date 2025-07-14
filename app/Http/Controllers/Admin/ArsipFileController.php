<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArsipFile;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArsipFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $arsipFiles = ArsipFile::with(['client', 'creator'])
            ->where('status_deleted', false)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.arsip-file.index', compact('arsipFiles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'id_client' => 'nullable|exists:clients,id',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png,zip,rar|max:10240', // 10MB
            'status' => 'nullable|in:draft,on progress,done',
        ]);

        // Upload file
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('arsip_files', $fileName, 'public');

        // Create arsip file record
        $arsipFile = ArsipFile::create([
            'nama' => $request->nama,
            'id_client' => $request->id_client,
            'file' => $filePath,
            'status_deleted' => false,
            'status' => $request->status ?? ArsipFile::STATUS_DRAFT,
            'created_by' => Auth::id(),
        ]);

        // Log activity
        ActivityLogService::logCreate(
            'ArsipFile',
            'Menambahkan arsip file: ' . $request->nama,
            $arsipFile->toArray()
        );

        return redirect()->back()->with('success', 'Arsip file berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:draft,on progress,done',
        ]);

        $arsipFile = ArsipFile::findOrFail($id);
        $oldStatus = $arsipFile->status;
        
        $arsipFile->update([
            'status' => $request->status,
        ]);

        // Log activity
        ActivityLogService::logUpdate(
            'ArsipFile',
            'Mengubah status arsip file: ' . $arsipFile->nama . ' dari ' . $oldStatus . ' ke ' . $request->status,
            ['status' => $oldStatus],
            ['status' => $request->status]
        );

        return redirect()->back()->with('success', 'Status arsip file berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $arsipFile = ArsipFile::findOrFail($id);
        $oldData = $arsipFile->toArray();
        
        // Update status_deleted to true instead of deleting
        $arsipFile->update(['status_deleted' => true]);
        
        // Log activity
        ActivityLogService::logDelete(
            'ArsipFile',
            'Menghapus arsip file: ' . $arsipFile->nama,
            $oldData
        );
        
        return redirect()->back()->with('success', 'Arsip file berhasil dihapus!');
    }
}
