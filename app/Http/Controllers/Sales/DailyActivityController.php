<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\DailyActivity;
use App\Models\User;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageService;
use App\Services\ActivityLogService;

class DailyActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DailyActivity::with(['creator', 'client'])
            ->where('deleted_status', false)
            ->where('created_by', auth()->id()); // Hanya ambil data milik user yang login

        // Set default date to today if no date is selected
        $startDate = $request->filled('start_date') ? $request->start_date : now()->format('Y-m-d');
        $endDate = $request->filled('end_date') ? $request->end_date : now()->format('Y-m-d');

        // Filter by date range
        $query->whereDate('created_at', '>=', $startDate)
              ->whereDate('created_at', '<=', $endDate);

        $activities = $query->latest()->paginate(5);
        $users = User::where('status_deleted', 0)->get();

        return view('sales.daily-activity.index', compact('activities', 'users', 'startDate', 'endDate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('status_deleted', 0)->get();
        $clients = \App\Models\Client::where('created_by', auth()->id())
                                    ->where('status_deleted', false)
                                    ->orderBy('nama')
                                    ->get();
        return view('sales.daily-activity.create', compact('users', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Debug logging untuk request
        \Log::info('Sales DailyActivity Store Request', [
            'user_id' => auth()->id(),
            'has_files' => $request->hasFile('dokumentasi'),
            'files_count' => $request->hasFile('dokumentasi') ? count($request->file('dokumentasi')) : 0,
            'request_size' => strlen(serialize($request->all())),
            'perihal' => $request->perihal,
            'pihak_bersangkutan' => $request->pihak_bersangkutan
        ]);

        try {
            $validated = $request->validate([
                'perihal' => 'required|string|max:255',
                'pihak_bersangkutan' => 'required|exists:clients,id',
                'dokumentasi.*' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'summary' => 'nullable|string',
            ], [
                'perihal.required' => 'Tujuan kegiatan harus diisi',
                'perihal.max' => 'Tujuan kegiatan maksimal 255 karakter',
                'pihak_bersangkutan.required' => 'Pelanggan harus dipilih',
                'pihak_bersangkutan.exists' => 'Pelanggan yang dipilih tidak valid',
                'dokumentasi.*.image' => 'File harus berupa gambar',
                'dokumentasi.*.mimes' => 'Format file harus JPEG, PNG, JPG, atau GIF',
                'summary.string' => 'Pembahasan harus berupa teks'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error in DailyActivity store', [
                'errors' => $e->errors(),
                'user_id' => auth()->id(),
                'request_data' => $request->except(['dokumentasi'])
            ]);
            
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        }

        $dokumentasi = [];
        if ($request->hasFile('dokumentasi')) {
            try {
                // Log file details sebelum upload
                $files = $request->file('dokumentasi');
                foreach ($files as $index => $file) {
                    \Log::info("File {$index} details", [
                        'name' => $file->getClientOriginalName(),
                        'size' => $file->getSize(),
                        'mime' => $file->getMimeType(),
                        'extension' => $file->getClientOriginalExtension()
                    ]);
                }

                $dokumentasi = ImageService::compressAndStoreMultiple(
                    $request->file('dokumentasi'),
                    'dokumentasi',
                    80,
                    1920,
                    1080
                );

                \Log::info('Upload successful', [
                    'uploaded_paths' => $dokumentasi,
                    'count' => count($dokumentasi)
                ]);
            } catch (\Exception $e) {
                \Log::error('Upload dokumentasi error', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'user_id' => auth()->id(),
                    'files_count' => count($request->file('dokumentasi'))
                ]);
                
                // Berikan pesan error yang lebih spesifik
                $errorMessage = 'Gagal mengupload dokumentasi. ';
                if (strpos($e->getMessage(), 'file_get_contents') !== false) {
                    $errorMessage .= 'File terlalu besar atau rusak. Coba kompres file atau pilih file yang lebih kecil.';
                } elseif (strpos($e->getMessage(), 'Permission denied') !== false) {
                    $errorMessage .= 'Tidak ada izin untuk menyimpan file. Hubungi administrator.';
                } elseif (strpos($e->getMessage(), 'No space left') !== false) {
                    $errorMessage .= 'Penyimpanan penuh. Hubungi administrator.';
                } else {
                    $errorMessage .= 'Detail error: ' . $e->getMessage();
                }
                
                return redirect()->back()
                    ->withInput()
                    ->with('error', $errorMessage);
            }
        }

        try {
            $activity = DailyActivity::create([
                'perihal' => $validated['perihal'],
                'pihak_bersangkutan' => $validated['pihak_bersangkutan'],
                'dokumentasi' => $dokumentasi,
                'summary' => $validated['summary'],
                'lokasi' => $request->lokasi,
                'created_by' => auth()->id(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Database error in DailyActivity store', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'data' => $validated
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan aktivitas. Silakan coba lagi atau hubungi administrator jika masalah berlanjut.');
        }

        // Create or update attendance record
        $today = now()->format('Y-m-d');
        $userId = auth()->id();
        
        // Count today's activities for this user
        $todayActivitiesCount = DailyActivity::where('created_by', $userId)
            ->whereDate('created_at', $today)
            ->where('deleted_status', false)
            ->count();

        // Create or update attendance record
        $absensi = Absensi::updateOrCreate(
            [
                'id_user' => $userId,
                'tgl_absen' => $today,
            ],
            [
                'status_absen' => $todayActivitiesCount >= 3 ? 1 : 0, // 1 for Hadir, 0 for Alpha
                'count' => $todayActivitiesCount,
                'id_daily_activity' => $activity->id,
                'deleted_status' => false
            ]
        );

        // Log aktivitas
        ActivityLogService::logCreate(
            'DailyActivity',
            "Sales membuat aktivitas baru: {$activity->perihal}",
            $activity->toArray()
        );

        $message = 'Aktivitas berhasil ditambahkan.';
        if ($todayActivitiesCount >= 3) {
            $message .= ' Absensi Anda telah berhasil (Hadir).';
        } else {
            $message .= ' Anda perlu menambahkan ' . (3 - $todayActivitiesCount) . ' aktivitas lagi untuk menyelesaikan absensi.';
        }

        return redirect()
            ->route('sales.daily-activity.show', $activity)
            ->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(DailyActivity $dailyActivity)
    {
        $dailyActivity->load(['creator', 'client']);
        return view('sales.daily-activity.show', compact('dailyActivity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DailyActivity $dailyActivity)
    {
        $users = User::where('status_deleted', 0)->get();
        $clients = \App\Models\Client::where('created_by', auth()->id())
                                    ->where('status_deleted', false)
                                    ->orderBy('nama')
                                    ->get();
        return view('sales.daily-activity.edit', compact('dailyActivity', 'users', 'clients'));
    }

    /**
     * Add a comment to the daily activity.
     */
    public function comment(Request $request, DailyActivity $dailyActivity)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $comments = json_decode($dailyActivity->komentar ?? '[]', true);
        
        $comments[] = [
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'message' => $request->message,
            'timestamp' => now()->toIso8601String(),
        ];

        $dailyActivity->update([
            'komentar' => json_encode($comments)
        ]);

        // Log aktivitas komentar
        ActivityLogService::log(
            'comment',
            'DailyActivity',
            "Sales menambahkan komentar pada aktivitas: {$dailyActivity->perihal}",
            $dailyActivity->toArray(),
            $dailyActivity->fresh()->toArray()
        );

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DailyActivity $dailyActivity)
    {
        try {
            $validated = $request->validate([
                'perihal' => 'required|string|max:255',
                'pihak_bersangkutan' => 'required|exists:clients,id',
                'dokumentasi.*' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'deleted_images' => 'nullable|string',
                'summary' => 'nullable|string',
            ], [
                'perihal.required' => 'Tujuan kegiatan harus diisi',
                'perihal.max' => 'Tujuan kegiatan maksimal 255 karakter',
                'pihak_bersangkutan.required' => 'Pelanggan harus dipilih',
                'pihak_bersangkutan.exists' => 'Pelanggan yang dipilih tidak valid',
                'dokumentasi.*.image' => 'File harus berupa gambar',
                'dokumentasi.*.mimes' => 'Format file harus JPEG, PNG, JPG, atau GIF',
                'summary.string' => 'Pembahasan harus berupa teks'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error in DailyActivity update', [
                'errors' => $e->errors(),
                'user_id' => auth()->id(),
                'activity_id' => $dailyActivity->id,
                'request_data' => $request->except(['dokumentasi'])
            ]);
            
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        }

        // Simpan data lama untuk logging
        $oldData = $dailyActivity->toArray();

        $dokumentasi = is_array($dailyActivity->dokumentasi) ? $dailyActivity->dokumentasi : json_decode($dailyActivity->dokumentasi, true) ?? [];
        
        // Hapus gambar yang dihapus
        if ($request->filled('deleted_images')) {
            $deletedImages = json_decode($request->deleted_images, true);
            if (is_array($deletedImages)) {
                foreach ($deletedImages as $image) {
                    if (($key = array_search($image, $dokumentasi)) !== false) {
                        Storage::disk('public')->delete($dokumentasi[$key]);
                        unset($dokumentasi[$key]);
                    }
                }
                $dokumentasi = array_values($dokumentasi);
            }
        }

        // Upload dan compress gambar baru
        if ($request->hasFile('dokumentasi')) {
            try {
                $newImages = ImageService::compressAndStoreMultiple(
                    $request->file('dokumentasi'),
                    'dokumentasi',
                    80,
                    1920,
                    1080
                );
                $dokumentasi = array_merge($dokumentasi, $newImages);
            } catch (\Exception $e) {
                \Log::error('Upload dokumentasi error in update', [
                    'error' => $e->getMessage(),
                    'user_id' => auth()->id(),
                    'activity_id' => $dailyActivity->id,
                    'files_count' => count($request->file('dokumentasi'))
                ]);
                
                // Berikan pesan error yang lebih spesifik
                $errorMessage = 'Gagal mengupload dokumentasi. ';
                if (strpos($e->getMessage(), 'file_get_contents') !== false) {
                    $errorMessage .= 'File terlalu besar atau rusak. Coba kompres file atau pilih file yang lebih kecil.';
                } elseif (strpos($e->getMessage(), 'Permission denied') !== false) {
                    $errorMessage .= 'Tidak ada izin untuk menyimpan file. Hubungi administrator.';
                } elseif (strpos($e->getMessage(), 'No space left') !== false) {
                    $errorMessage .= 'Penyimpanan penuh. Hubungi administrator.';
                } else {
                    $errorMessage .= 'Detail error: ' . $e->getMessage();
                }
                
                return redirect()->back()
                    ->withInput()
                    ->with('error', $errorMessage);
            }
        }

        try {
            $dailyActivity->update([
                'perihal' => $validated['perihal'],
                'pihak_bersangkutan' => $validated['pihak_bersangkutan'],
                'dokumentasi' => $dokumentasi,
                'summary' => $validated['summary'],
            ]);
        } catch (\Exception $e) {
            \Log::error('Database error in DailyActivity update', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'activity_id' => $dailyActivity->id,
                'data' => $validated
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui aktivitas. Silakan coba lagi atau hubungi administrator jika masalah berlanjut.');
        }

        // Log aktivitas
        ActivityLogService::logUpdate(
            'DailyActivity',
            "Sales mengupdate aktivitas: {$dailyActivity->perihal}",
            $oldData,
            $dailyActivity->fresh()->toArray()
        );

        return redirect()
            ->route('sales.daily-activity.show', $dailyActivity)
            ->with('success', 'Aktivitas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DailyActivity $dailyActivity)
    {
        // Simpan data untuk logging
        $oldData = $dailyActivity->toArray();

        // Update status deleted
        $dailyActivity->update([
            'deleted_status' => true
        ]);

        // Hitung ulang jumlah aktivitas hari ini yang tidak dihapus
        $today = date('Y-m-d', strtotime($dailyActivity->created_at));
        $userId = $dailyActivity->created_by;
        
        $todayActivitiesCount = DailyActivity::where('created_by', $userId)
            ->whereDate('created_at', $today)
            ->where('deleted_status', false)
            ->count();
        
        // Update record absensi
        $absensi = Absensi::where('id_user', $userId)
            ->whereDate('tgl_absen', $today)
            ->first();
        
        if ($absensi) {
            $absensi->update([
                'status_absen' => $todayActivitiesCount >= 3 ? 1 : 0,
                'count' => $todayActivitiesCount
            ]);
        }

        // Log aktivitas
        ActivityLogService::logDelete(
            'DailyActivity',
            "Sales menghapus aktivitas: {$dailyActivity->perihal}",
            $oldData
        );

        return redirect()
            ->route('sales.daily-activity.index')
            ->with('success', 'Aktivitas berhasil dihapus.');
    }
}