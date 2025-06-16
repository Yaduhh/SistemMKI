<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\ArsipFile;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArsipFileController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'id_client' => 'nullable|exists:clients,id',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png,zip,rar|max:10240', // 10MB
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
     * Soft delete the specified resource.
     */
    public function destroy(ArsipFile $arsipFile)
    {

        // Ensure the client belongs to the authenticated sales user
        $currentUserId = Auth::id();
        $fileCreatedBy = $arsipFile->created_by;
        
        // Debug information
        $currentUserType = gettype($currentUserId);
        $fileCreatedByType = gettype($fileCreatedBy);
        
        if ((int)$arsipFile->created_by !== (int)Auth::id()) {
            abort(403, "Unauthorized action. Current User ID: {$currentUserId} ({$currentUserType}), File Created By: {$fileCreatedBy} ({$fileCreatedByType})");
        }

        // Store old data for logging
        $oldData = $arsipFile->toArray();

        // Soft delete by setting status_deleted to true
        $arsipFile->update(['status_deleted' => true]);

        // Log activity
        ActivityLogService::log(
            'delete',
            'ArsipFile',
            'Menghapus arsip file: ' . $arsipFile->nama,
            $oldData,
            ['status_deleted' => true]
        );

        return redirect()->back()->with('success', 'Arsip file berhasil dihapus.');
    }
} 