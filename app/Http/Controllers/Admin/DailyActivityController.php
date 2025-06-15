<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyActivity;
use App\Models\User;
use App\Models\Client;
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
            ->where('deleted_status', false);

        // Filter by user
        if ($request->filled('user')) {
            $query->where('created_by', $request->user);
        }

        // Set default date to today if no date is selected
        $startDate = $request->filled('start_date') ? $request->start_date : now()->format('Y-m-d');
        $endDate = $request->filled('end_date') ? $request->end_date : now()->format('Y-m-d');

        // Filter by date range
        $query->whereDate('created_at', '>=', $startDate)
              ->whereDate('created_at', '<=', $endDate);

        $activities = $query->latest()->paginate(10);
        
        // Get all active users and order by name
        $users = User::where('status_deleted', 0)
                    ->orderBy('name')
                    ->get();

        return view('admin.daily-activity.index', compact('activities', 'users', 'startDate', 'endDate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('status_deleted', 0)->get();
        $clients = Client::where('status_deleted', false)
                        ->orderBy('nama')
                        ->get();
        return view('admin.daily-activity.create', compact('users', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'perihal' => 'required|string|max:255',
            'pihak_bersangkutan' => 'required|exists:clients,id',
            'dokumentasi.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4048',
            'summary' => 'nullable|string',
        ]);

        $dokumentasi = [];
        if ($request->hasFile('dokumentasi')) {
            $dokumentasi = ImageService::compressAndStoreMultiple(
                $request->file('dokumentasi'),
                'dokumentasi',
                80,
                1920,
                1080
            );
        }

        $activity = DailyActivity::create([
            'perihal' => $validated['perihal'],
            'pihak_bersangkutan' => $validated['pihak_bersangkutan'],
            'dokumentasi' => $dokumentasi,
            'summary' => $validated['summary'],
            'lokasi' => $request->lokasi,
            'created_by' => auth()->id(),
        ]);

        // Log aktivitas
        ActivityLogService::logCreate(
            'DailyActivity',
            "Admin membuat aktivitas baru: {$activity->perihal}",
            $activity->toArray()
        );

        return redirect()
            ->route('admin.daily-activity.show', $activity)
            ->with('success', 'Aktivitas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DailyActivity $dailyActivity)
    {
        $dailyActivity->load(['creator', 'client']);
        return view('admin.daily-activity.show', compact('dailyActivity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DailyActivity $dailyActivity)
    {
        $users = User::where('status_deleted', 0)->get();
        $clients = Client::where('status_deleted', false)
                        ->orderBy('nama')
                        ->get();
        return view('admin.daily-activity.edit', compact('dailyActivity', 'users', 'clients'));
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

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DailyActivity $dailyActivity)
    {
        $validated = $request->validate([
            'perihal' => 'required|string|max:255',
            'pihak_bersangkutan' => 'required|exists:clients,id',
            'dokumentasi.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4048',
            'deleted_images' => 'nullable|string',
            'summary' => 'nullable|string',
        ]);

        // Simpan data lama untuk logging
        $oldData = $dailyActivity->toArray();

        // Handle dokumentasi
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
        
        if ($request->hasFile('dokumentasi')) {
            $newImages = ImageService::compressAndStoreMultiple(
                $request->file('dokumentasi'),
                'dokumentasi',
                80,
                1920,
                1080
            );
            $dokumentasi = array_merge($dokumentasi, $newImages);
        }

        $dailyActivity->update([
            'perihal' => $validated['perihal'],
            'pihak_bersangkutan' => $validated['pihak_bersangkutan'],
            'dokumentasi' => $dokumentasi,
            'summary' => $validated['summary'],
        ]);

        // Log aktivitas
        ActivityLogService::logUpdate(
            'DailyActivity',
            "Admin mengupdate aktivitas: {$dailyActivity->perihal}",
            $oldData,
            $dailyActivity->fresh()->toArray()
        );

        return redirect()
            ->route('admin.daily-activity.show', $dailyActivity)
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

        // Log aktivitas
        ActivityLogService::logDelete(
            'DailyActivity',
            "Admin menghapus aktivitas: {$dailyActivity->perihal}",
            $oldData
        );

        return redirect()
            ->route('admin.daily-activity.index')
            ->with('success', 'Aktivitas berhasil dihapus.');
    }
}
