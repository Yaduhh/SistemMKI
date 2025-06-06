<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyActivity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return view('daily-activity.index', compact('activities', 'users', 'startDate', 'endDate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('status_deleted', 0)->get();
        return view('daily-activity.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'dokumentasi' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'perihal' => 'required|string',
            'pihak_bersangkutan' => 'required|string',
        ]);

        // Handle file upload
        if ($request->hasFile('dokumentasi')) {
            $file = $request->file('dokumentasi');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('dokumentasi', $filename, 'public');
            $validated['dokumentasi'] = 'storage/dokumentasi/' . $filename;
        }

        $validated['created_by'] = Auth::id();
        $validated['deleted_status'] = false;

        DailyActivity::create($validated);

        return redirect()
            ->route('admin.daily-activity.index')
            ->with('success', 'Aktivitas harian berhasil ditambahkan.');
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
    public function edit(DailyActivity $dailyActivity)
    {
        $users = User::where('status_deleted', 0)->get();
        return view('daily-activity.edit', compact('dailyActivity', 'users'));
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

        return redirect()
            ->route('admin.daily-activity.index')
            ->with('success', 'Komentar berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DailyActivity $dailyActivity)
    {
        // Check if user is authorized to edit
        if ($dailyActivity->created_by !== Auth::id()) {
            return redirect()
                ->route('admin.daily-activity.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit aktivitas ini.');
        }

        $validated = $request->validate([
            'dokumentasi' => 'required|string',
            'perihal' => 'required|string',
            'pihak_bersangkutan' => 'required|string',
        ]);

        $dailyActivity->update($validated);

        return redirect()
            ->route('admin.daily-activity.index')
            ->with('success', 'Aktivitas harian berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DailyActivity $dailyActivity)
    {
        // Check if user is authorized to delete
        if ($dailyActivity->created_by !== Auth::id()) {
            return redirect()
                ->route('admin.daily-activity.index')
                ->with('error', 'Anda tidak memiliki akses untuk menghapus aktivitas ini.');
        }

        $dailyActivity->update(['deleted_status' => true]);
        return redirect()
            ->route('admin.daily-activity.index')
            ->with('success', 'Aktivitas harian berhasil dihapus.');
    }
}
