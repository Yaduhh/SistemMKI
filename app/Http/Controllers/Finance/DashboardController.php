<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Distributor;
use App\Models\User;
use App\Models\DailyActivity;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $clientCount = Client::where('status_deleted', false)->count();
        $distributorCount = Distributor::where('status_deleted', false)->count();
        $financeCount = User::where('role', 3)->where('status_deleted', false)->count();
        $digitalMarketingCount = User::where('role', 4)->where('status_deleted', false)->count();
        $dailyActivityCount = DailyActivity::where('deleted_status', false)->count();
        $recentClients = Client::where('status_deleted', false)->latest()->take(5)->get();
        $recentDistributors = Distributor::where('status_deleted', false)->latest()->take(5)->get();
        $recentActivities = DailyActivity::with('creator')->latest()->take(5)->get();
        $recentLogs = ActivityLog::with('user')->latest()->take(5)->get();

        return view('finance.dashboard', compact(
            'clientCount',
            'distributorCount',
            'financeCount',
            'digitalMarketingCount',
            'dailyActivityCount',
            'recentClients',
            'recentDistributors',
            'recentActivities',
            'recentLogs'
        ));
    }

    public function logs()
    {
        $logs = ActivityLog::with('user')->latest()->paginate(10);
        return view('finance.logs', compact('logs'));
    }
} 