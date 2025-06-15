<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\User;
use App\Models\DailyActivity;
use Carbon\Carbon;
use App\Services\ActivityLogService;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get all active users
        $users = User::where('status_deleted', 0)->where('role', 2)->get();
        
        // Set default date to today if no date is selected
        $startDate = $request->filled('filter_date') ? $request->filter_date : now()->format('Y-m-d');
        
        $query = Absensi::with(['user', 'dailyActivity'])
            ->where('deleted_status', false);

        // Filter by user
        if ($request->filled('user')) {
            $query->where('id_user', $request->user);
        }

        // Filter by single date
        $query->whereDate('tgl_absen', $startDate);

        $absensi = $query->orderBy('tgl_absen', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Calculate totals for the filtered date
        $totalHadir = Absensi::where('deleted_status', false)
            ->where('status_absen', 1)
            ->whereDate('tgl_absen', $startDate);

        $totalIzin = Absensi::where('deleted_status', false)
            ->where('status_absen', 2)
            ->whereDate('tgl_absen', $startDate);

        $totalSakit = Absensi::where('deleted_status', false)
            ->where('status_absen', 3)
            ->whereDate('tgl_absen', $startDate);

        $totalAlpha = Absensi::where('deleted_status', false)
            ->where('status_absen', 0)
            ->whereDate('tgl_absen', $startDate);

        // Apply user filter to totals if specified
        if ($request->filled('user')) {
            $totalHadir->where('id_user', $request->user);
            $totalIzin->where('id_user', $request->user);
            $totalSakit->where('id_user', $request->user);
            $totalAlpha->where('id_user', $request->user);
        }

        return view('admin.absensi.index', compact(
            'absensi', 
            'users',
            'totalHadir', 
            'totalIzin', 
            'totalSakit', 
            'totalAlpha',
            'startDate'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Absensi $absensi)
    {
        return view('admin.absensi.edit', compact('absensi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Absensi $absensi)
    {
        $validated = $request->validate([
            'status_absen' => 'required|integer|between:0,3',
        ]);

        // Save old data for logging
        $oldData = $absensi->toArray();

        $absensi->update([
            'status_absen' => $validated['status_absen'],
        ]);

        // Log aktivitas
        ActivityLogService::logUpdate(
            'Absensi',
            "Admin mengubah status absensi user {$absensi->user->name} tanggal {$absensi->tgl_absen->format('d-m-Y')}",
            $oldData,
            $absensi->toArray()
        );

        return redirect()
            ->route('admin.absensi.index')
            ->with('success', 'Status absensi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Absensi $absensi)
    {
        // Save old data for logging
        $oldData = $absensi->toArray();

        $absensi->update([
            'deleted_status' => true,
        ]);

        // Log aktivitas
        ActivityLogService::logDelete(
            'Absensi',
            "Admin menghapus absensi user {$absensi->user->name} tanggal {$absensi->tgl_absen->format('d-m-Y')}",
            $oldData
        );

        return redirect()
            ->route('admin.absensi.index')
            ->with('success', 'Absensi berhasil dihapus.');
    }
}