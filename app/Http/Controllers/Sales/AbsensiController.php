<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\DailyActivity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();
        
        // Get today's activities for the authenticated user
        $todayActivities = DailyActivity::where('created_by', auth()->id())
            ->whereDate('created_at', $today)
            ->where('deleted_status', false)
            ->count();

        // Get or create today's attendance record
        $todayAbsensi = Absensi::firstOrCreate(
            [
                'id_user' => auth()->id(),
                'tgl_absen' => $today,
            ],
            [
                'status_absen' => 0, // Default to Alpha
                'deleted_status' => false,
            ]
        );

        // Update status if there are 3 or more activities
        if ($todayActivities >= 3) {
            $todayAbsensi->update(['status_absen' => 1]); // Set to Hadir
        }

        // Get monthly attendance history
        $query = Absensi::with('user')
            ->where('deleted_status', false);

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->where('tgl_absen', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->where('tgl_absen', '<=', $request->end_date);
        }

        // Calculate totals
        $totalHadir = Absensi::where('deleted_status', false)
            ->where('status_absen', 1)
            ->count();
        $totalIzin = Absensi::where('deleted_status', false)
            ->where('status_absen', 2)
            ->count();
        $totalSakit = Absensi::where('deleted_status', false)
            ->where('status_absen', 3)
            ->count();
        $totalAlpha = Absensi::where('deleted_status', false)
            ->where('status_absen', 0)
            ->where('tgl_absen', '<', $today) // Exclude today's records
            ->count();

        $absensi = $query->orderBy('tgl_absen', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('sales.absensi.index', compact('absensi', 'totalHadir', 'totalIzin', 'totalSakit', 'totalAlpha'));
    }

    public function create()
    {
        return view('sales.absensi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'status' => 'required|in:hadir,izin,sakit,alpha',
        ]);

        $absensi = Absensi::create([
            'id_user' => Auth::id(),
            'tgl_absen' => $validated['tanggal'],
            'status' => $validated['status'],
            'deleted_status' => false,
        ]);

        return redirect()
            ->route('sales.absensi.index')
            ->with('success', 'Absensi berhasil ditambahkan.');
    }

    public function edit(Absensi $absensi)
    {
        return view('sales.absensi.edit', compact('absensi'));
    }

    public function update(Request $request, Absensi $absensi)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'status' => 'required|in:hadir,izin,sakit,alpha',
        ]);

        $absensi->update([
            'tgl_absen' => $validated['tanggal'],
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('sales.absensi.index')
            ->with('success', 'Absensi berhasil diperbarui.');
    }

    public function destroy(Absensi $absensi)
    {
        $absensi->update(['deleted_status' => true]);

        return redirect()
            ->route('sales.absensi.index')
            ->with('success', 'Absensi berhasil dihapus.');
    }
} 