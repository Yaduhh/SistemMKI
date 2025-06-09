<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\DailyActivity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DailyActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DailyActivity::with('creator')
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
        $users = User::where('status_deleted', 0)->get();

        return view('sales.daily-activity.index', compact('activities', 'users', 'startDate', 'endDate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('status_deleted', 0)->get();
        return view('sales.daily-activity.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'perihal' => 'required|string|max:255',
            'pihak_bersangkutan' => 'required|string|max:255',
            'dokumentasi.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $dokumentasi = [];
        if ($request->hasFile('dokumentasi')) {
            foreach ($request->file('dokumentasi') as $image) {
                $path = $image->store('dokumentasi', 'public');
                $dokumentasi[] = $path;
            }
        }

        $activity = DailyActivity::create([
            'perihal' => $validated['perihal'],
            'pihak_bersangkutan' => $validated['pihak_bersangkutan'],
            'dokumentasi' => $dokumentasi,
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('sales.daily-activity.show', $activity)
            ->with('success', 'Aktivitas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DailyActivity $dailyActivity)
    {
        $dailyActivity->load('creator');
        return view('sales.daily-activity.show', compact('dailyActivity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DailyActivity $dailyActivity)
    {
        $users = User::where('status_deleted', 0)->get();
        return view('sales.daily-activity.edit', compact('dailyActivity', 'users'));
    }

    /**
     * Add a comment to the daily activity.
     */
    public function comment(Request $request, DailyActivity $dailyActivity)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
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
            'pihak_bersangkutan' => 'required|string|max:255',
            'dokumentasi.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deleted_images' => 'nullable|string',
        ]);

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
                $dokumentasi = array_values($dokumentasi); // Reindex array
            }
        }

        // Upload gambar baru
        if ($request->hasFile('dokumentasi')) {
            foreach ($request->file('dokumentasi') as $image) {
                $path = $image->store('dokumentasi', 'public');
                $dokumentasi[] = $path;
            }
        }

        $dailyActivity->update([
            'perihal' => $validated['perihal'],
            'pihak_bersangkutan' => $validated['pihak_bersangkutan'],
            'dokumentasi' => $dokumentasi,
        ]);

        return redirect()
            ->route('sales.daily-activity.show', $dailyActivity)
            ->with('success', 'Aktivitas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DailyActivity $dailyActivity)
    {
        // Hapus semua gambar dokumentasi
        if ($dailyActivity->dokumentasi) {
            foreach ($dailyActivity->dokumentasi as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $dailyActivity->delete();

        return redirect()
            ->route('sales.daily-activity.index')
            ->with('success', 'Aktivitas berhasil dihapus.');
    }
} 