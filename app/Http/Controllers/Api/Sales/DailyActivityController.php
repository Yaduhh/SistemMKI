<?php

namespace App\Http\Controllers\Api\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DailyActivityController extends Controller
{
    private function getFullImageUrl($path)
    {
        // Hapus awalan /storage/ jika ada
        $path = ltrim($path, '/storage/');
        // Tambahkan URL lengkap
        return url('storage/' . $path);
    }

    private function transformDokumentasi($dokumentasi)
    {
        if (!$dokumentasi) {
            return [];
        }

        // Jika sudah array, langsung gunakan
        if (is_array($dokumentasi)) {
            return array_map([$this, 'getFullImageUrl'], $dokumentasi);
        }

        // Jika string, decode dulu
        $paths = json_decode($dokumentasi, true);
        if (!is_array($paths)) {
            return [];
        }

        return array_map([$this, 'getFullImageUrl'], $paths);
    }

    public function recent(Request $request)
    {
        $limit = $request->get('limit', 5);
        $user = Auth::user();
        
        $activities = DailyActivity::where('created_by', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
            
        // Transform dokumentasi URLs
        $activities->transform(function ($activity) {
            $activity->dokumentasi = $this->transformDokumentasi($activity->dokumentasi);
            return $activity;
        });
            
        return response()->json([
            'data' => $activities
        ]);
    }
    
    public function index()
    {
        $user = Auth::user();
        
        $activities = DailyActivity::where('created_by', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        // Transform dokumentasi URLs
        $activities->getCollection()->transform(function ($activity) {
            $activity->dokumentasi = $this->transformDokumentasi($activity->dokumentasi);
            return $activity;
        });
            
        return response()->json([
            'data' => $activities
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'perihal' => 'required|string',
            'pihak_bersangkutan' => 'required|string',
            'summary' => 'nullable|string',
            'dokumentasi.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        $dokumentasi = [];
        if ($request->hasFile('dokumentasi')) {
            foreach ($request->file('dokumentasi') as $file) {
                $path = $file->store('dokumentasi', 'public');
                $dokumentasi[] = $path;
            }
        }
        
        $activity = DailyActivity::create([
            'created_by' => Auth::id(),
            'perihal' => $request->perihal,
            'pihak_bersangkutan' => $request->pihak_bersangkutan,
            'summary' => $request->summary,
            'dokumentasi' => !empty($dokumentasi) ? json_encode($dokumentasi) : null,
        ]);
        
        // Transform dokumentasi URLs
        $activity->dokumentasi = $this->transformDokumentasi($activity->dokumentasi);
        
        return response()->json([
            'data' => $activity,
            'message' => 'Aktivitas berhasil ditambahkan'
        ], 201);
    }
    
    public function show(DailyActivity $dailyActivity)
    {
        // Check if the activity belongs to the current user
        if ($dailyActivity->created_by !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        // Transform dokumentasi URLs
        $dailyActivity->dokumentasi = $this->transformDokumentasi($dailyActivity->dokumentasi);
        
        return response()->json([
            'data' => $dailyActivity
        ]);
    }
    
    public function update(Request $request, DailyActivity $dailyActivity)
    {
        // Check if the activity belongs to the current user
        if ($dailyActivity->created_by !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        $request->validate([
            'perihal' => 'required|string',
            'pihak_bersangkutan' => 'required|string',
            'summary' => 'nullable|string',
            'dokumentasi.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        // Handle file uploads
        $dokumentasi = [];
        if ($request->hasFile('dokumentasi')) {
            // Delete old files
            $oldFiles = $this->transformDokumentasi($dailyActivity->dokumentasi);
            if (is_array($oldFiles)) {
                foreach ($oldFiles as $file) {
                    $path = str_replace(url('storage/'), '', $file);
                    Storage::disk('public')->delete($path);
                }
            }
            
            // Upload new files
            foreach ($request->file('dokumentasi') as $file) {
                $path = $file->store('dokumentasi', 'public');
                $dokumentasi[] = $path;
            }
        }
        
        $dailyActivity->update([
            'perihal' => $request->perihal,
            'pihak_bersangkutan' => $request->pihak_bersangkutan,
            'summary' => $request->summary,
            'dokumentasi' => !empty($dokumentasi) ? json_encode($dokumentasi) : $dailyActivity->dokumentasi,
        ]);
        
        // Transform dokumentasi URLs
        $dailyActivity->dokumentasi = $this->transformDokumentasi($dailyActivity->dokumentasi);
        
        return response()->json([
            'data' => $dailyActivity,
            'message' => 'Aktivitas berhasil diperbarui'
        ]);
    }
    
    public function destroy(DailyActivity $dailyActivity)
    {
        // Check if the activity belongs to the current user
        if ($dailyActivity->created_by !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        // Delete associated files
        $files = $this->transformDokumentasi($dailyActivity->dokumentasi);
        if (is_array($files)) {
            foreach ($files as $file) {
                $path = str_replace(url('storage/'), '', $file);
                Storage::disk('public')->delete($path);
            }
        }
        
        $dailyActivity->delete();
        
        return response()->json([
            'message' => 'Aktivitas berhasil dihapus'
        ]);
    }
} 