<?php

namespace App\Http\Controllers\Supervisi;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\DailyActivity;
use App\Models\Pengajuan;
use App\Models\Produk;
use App\Models\RancanganAnggaranBiaya;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the supervisi dashboard.
     */
    public function index()
    {
        // Get counts for statistics
        $clientCount = Client::count();
        $dailyActivityCount = DailyActivity::count();
        $pengajuanCount = Pengajuan::count();
        $produkCount = Produk::count();
        $rabCount = RancanganAnggaranBiaya::where('supervisi_id', auth()->id())->count();

        // Get recent data
        $recentClients = Client::latest()->take(5)->get();
        $recentActivities = DailyActivity::with('creator')->latest()->take(5)->get();
        $recentRABs = RancanganAnggaranBiaya::where('supervisi_id', auth()->id())
            ->with(['penawaran', 'pemasangan', 'user'])
            ->latest()
            ->take(5)
            ->get();

        return view('supervisi.dashboard', compact(
            'clientCount',
            'dailyActivityCount',
            'pengajuanCount',
            'produkCount',
            'rabCount',
            'recentClients',
            'recentActivities',
            'recentRABs'
        ));
    }

    /**
     * Display the activity logs page.
     */
    public function logs()
    {
        return view('supervisi.logs');
    }
}
