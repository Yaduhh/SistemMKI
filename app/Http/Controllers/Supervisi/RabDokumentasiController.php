<?php

namespace App\Http\Controllers\Supervisi;

use App\Http\Controllers\Controller;
use App\Models\RancanganAnggaranBiaya;
use App\Models\RabDokumentasi;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class RabDokumentasiController extends Controller
{
    public function upload(Request $request, RancanganAnggaranBiaya $rab)
    {
        // Debug: Log request data
        \Log::info('Upload dokumentasi request', [
            'rab_id' => $rab->id,
            'files_count' => $request->hasFile('dokumentasi') ? count($request->file('dokumentasi')) : 0,
            'user_id' => auth()->id(),
            'request_data' => $request->all()
        ]);

        $request->validate([
            'dokumentasi' => 'required|array|min:1',
            'dokumentasi.*' => 'required|image|mimes:jpeg,png,jpg,gif'
        ], [
            'dokumentasi.required' => 'File dokumentasi harus diisi',
            'dokumentasi.array' => 'File dokumentasi harus berupa array',
            'dokumentasi.min' => 'Minimal 1 file dokumentasi',
            'dokumentasi.*.required' => 'File dokumentasi harus diisi',
            'dokumentasi.*.image' => 'File harus berupa gambar',
            'dokumentasi.*.mimes' => 'Format file harus jpeg, png, jpg, atau gif'
        ]);

        try {
            $filePaths = ImageService::compressAndStoreMultiple(
                $request->file('dokumentasi'),
                'rab-dokumentasi',
                80,
                1920,
                1080
            );

            \Log::info('File paths generated', ['file_paths' => $filePaths]);

            $rabDokumentasi = RabDokumentasi::create([
                'rancangan_anggaran_biaya_id' => $rab->id,
                'file_paths' => $filePaths,
                'created_by' => Auth::id(),
                'status_deleted' => false
            ]);

            \Log::info('Dokumentasi created', ['dokumentasi_id' => $rabDokumentasi->id]);

            return redirect()->back()->with('success', 'Dokumentasi berhasil diupload');
        } catch (\Exception $e) {
            \Log::error('Upload dokumentasi error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Gagal mengupload dokumentasi: ' . $e->getMessage());
        }
    }

    public function delete(Request $request, RabDokumentasi $dokumentasi)
    {
        try {
            $filePath = $request->input('file_path');
            
            if ($filePath) {
                // Remove file from storage
                $relativePath = str_replace(asset('storage/'), '', $filePath);
                if (Storage::disk('public')->exists($relativePath)) {
                    Storage::disk('public')->delete($relativePath);
                }

                // Get raw file paths from database (without accessor)
                $rawFilePaths = json_decode($dokumentasi->getRawOriginal('file_paths'), true) ?? [];
                
                // Remove the specific file path
                $rawFilePaths = array_filter($rawFilePaths, function($path) use ($filePath) {
                    return asset('storage/' . $path) !== $filePath;
                });

                if (empty($rawFilePaths)) {
                    // If no files left, soft delete the entire record
                    $dokumentasi->update(['status_deleted' => true]);
                } else {
                    // Update with remaining file paths
                    $dokumentasi->update(['file_paths' => array_values($rawFilePaths)]);
                }
            } else {
                // Delete entire dokumentasi record
                $dokumentasi->update(['status_deleted' => true]);
            }

            return response()->json(['success' => true, 'message' => 'Dokumentasi berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus dokumentasi: ' . $e->getMessage()]);
        }
    }
}
