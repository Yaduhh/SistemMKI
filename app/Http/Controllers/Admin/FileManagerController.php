<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileManager;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = FileManager::with(['uploader'])
            ->where('status_deleted', false);

        // Search functionality
        if (request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('original_name', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('uploader', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by file type
        if (request('file_type') && request('file_type') !== '') {
            $query->where('file_type', request('file_type'));
        }

        // Filter by user
        if (request('user') && request('user') !== '') {
            $query->where('uploaded_by', request('user'));
        }

        // Filter by public status
        if (request('is_public') && request('is_public') !== '') {
            $query->where('is_public', request('is_public') === '1');
        }

        // Filter by featured status
        if (request('is_featured') && request('is_featured') !== '') {
            $query->where('is_featured', request('is_featured') === '1');
        }

        // Get users for filter dropdown
        $users = User::where('status_deleted', 0)->get();

        // Get filtered and paginated results
        $files = $query->latest()->paginate(20);

        return view('admin.file-manager.index', compact('files', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.file-manager.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'files' => 'required|array|min:1',
            'files.*' => 'required|file|max:10240', // Max 10MB per file
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'folder_path' => 'nullable|string|max:255',
            'is_public' => 'boolean',
            'is_featured' => 'boolean'
        ]);

        $uploadedFiles = [];

        foreach ($request->file('files') as $file) {
            $uploadedFile = $this->processFileUpload($file, $request);
            if ($uploadedFile) {
                $uploadedFiles[] = $uploadedFile;
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => count($uploadedFiles) . ' file berhasil diupload.',
                'files' => $uploadedFiles
            ]);
        }

        return redirect()->route('admin.file-manager.index')
            ->with('success', count($uploadedFiles) . ' file berhasil diupload.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FileManager $fileManager)
    {
        $fileManager->incrementViewCount();
        return view('admin.file-manager.show', compact('fileManager'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FileManager $fileManager)
    {
        return view('admin.file-manager.edit', compact('fileManager'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FileManager $fileManager)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'alt_text' => 'nullable|string|max:255',
            'folder_path' => 'nullable|string|max:255',
            'is_public' => 'boolean',
            'is_featured' => 'boolean'
        ]);

        $fileManager->update($request->only([
            'title', 'description', 'alt_text', 'folder_path', 'is_public', 'is_featured'
        ]));

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'File berhasil diupdate.'
            ]);
        }

        return redirect()->route('admin.file-manager.index')
            ->with('success', 'File berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FileManager $fileManager)
    {
        // Soft delete
        $fileManager->softDelete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'File berhasil dihapus.'
            ]);
        }

        return redirect()->route('admin.file-manager.index')
            ->with('success', 'File berhasil dihapus.');
    }

    /**
     * Download the specified file.
     */
    public function download(FileManager $fileManager)
    {
        $fileManager->incrementDownloadCount();

        // Debug: Log file path
        \Log::info('Download attempt:', [
            'file_id' => $fileManager->id,
            'file_path' => $fileManager->file_path,
            'original_name' => $fileManager->original_name,
            'storage_exists' => Storage::exists($fileManager->file_path),
            'storage_disk' => config('filesystems.default'),
            'public_disk' => config('filesystems.disks.public.root')
        ]);

        // Check if file exists in storage
        if (Storage::disk('public')->exists($fileManager->file_path)) {
            return Storage::disk('public')->download($fileManager->file_path, $fileManager->original_name);
        }

        // Try alternative path (without public prefix)
        $alternativePath = str_replace('file-manager/', '', $fileManager->file_path);
        if (Storage::disk('public')->exists($alternativePath)) {
            return Storage::disk('public')->download($alternativePath, $fileManager->original_name);
        }

        // Try with full path
        $fullPath = 'storage/' . $fileManager->file_path;
        if (file_exists(public_path($fullPath))) {
            return response()->download(public_path($fullPath), $fileManager->original_name);
        }

        \Log::error('File not found for download:', [
            'file_id' => $fileManager->id,
            'file_path' => $fileManager->file_path,
            'original_name' => $fileManager->original_name
        ]);

        return redirect()->back()->with('error', 'File tidak ditemukan di storage.');
    }

    /**
     * Toggle public status
     */
    public function togglePublic(FileManager $fileManager)
    {
        $fileManager->update(['is_public' => !$fileManager->is_public]);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Status publik berhasil diubah.',
                'is_public' => $fileManager->is_public
            ]);
        }

        return redirect()->back()->with('success', 'Status publik berhasil diubah.');
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(FileManager $fileManager)
    {
        $fileManager->update(['is_featured' => !$fileManager->is_featured]);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Status featured berhasil diubah.',
                'is_featured' => $fileManager->is_featured
            ]);
        }

        return redirect()->back()->with('success', 'Status featured berhasil diubah.');
    }

    /**
     * Process file upload
     */
    private function processFileUpload($file, Request $request)
    {
        try {
            // Generate unique filename
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            
            // Determine file type
            $mimeType = $file->getMimeType();
            $fileType = $this->getFileType($mimeType);
            
            // Create folder path
            $folderPath = $request->folder_path ? 'file-manager/' . $request->folder_path : 'file-manager';
            
            // Store file
            $filePath = $file->storeAs($folderPath, $fileName, 'public');
            
            // Get file size
            $fileSize = $file->getSize();
            $fileSizeHuman = $this->formatFileSize($fileSize);
            
            // Process image metadata if it's an image
            $metadata = [];
            if ($fileType === 'image') {
                // Get image dimensions using PHP's built-in functions
                $imageInfo = getimagesize($file->getPathname());
                if ($imageInfo) {
                    $metadata = [
                        'width' => $imageInfo[0],
                        'height' => $imageInfo[1],
                        'aspect_ratio' => round($imageInfo[0] / $imageInfo[1], 2)
                    ];
                }
            }
            
            // Create file manager record
            $fileManager = FileManager::create([
                'original_name' => $originalName,
                'file_name' => $fileName,
                'file_path' => $filePath,
                'file_url' => Storage::url($filePath),
                'mime_type' => $mimeType,
                'file_extension' => $extension,
                'file_type' => $fileType,
                'file_size' => $fileSize,
                'file_size_human' => $fileSizeHuman,
                'title' => $request->title,
                'description' => $request->description,
                'is_public' => $request->boolean('is_public', false),
                'is_featured' => $request->boolean('is_featured', false),
                'uploaded_by' => auth()->id(),
                'metadata' => $metadata
            ]);
            
            return $fileManager;
            
        } catch (\Exception $e) {
            \Log::error('File upload error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get file type from MIME type
     */
    private function getFileType($mimeType)
    {
        if (str_starts_with($mimeType, 'image/')) {
            return 'image';
        } elseif (str_starts_with($mimeType, 'video/')) {
            return 'video';
        } elseif (str_starts_with($mimeType, 'audio/')) {
            return 'audio';
        } elseif (in_array($mimeType, [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'text/plain',
            'text/csv'
        ])) {
            return 'document';
        }
        
        return 'other';
    }

    /**
     * Format file size to human readable
     */
    private function formatFileSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
