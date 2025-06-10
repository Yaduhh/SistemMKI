<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\DailyActivity;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get client count for the current sales user
        $clientCount = Client::where('created_by', $user->id)
            ->where('status_deleted', false)
            ->count();
        
        // Get upcoming events where user is invited and not completed
        $upcomingEventsCount = Event::where('jadwal', '>=', now())
            ->where('status', 'active')
            ->where('status_deleted', false)
            ->get()
            ->filter(function($event) use ($user) {
                return in_array($user->id, $event->peserta);
            })
            ->count();
        
        // Get recent daily activities (last 5) with better formatting
        $recentActivities = DailyActivity::where('created_by', $user->id)
            ->where('deleted_status', false)
            ->latest()
            ->take(5)
            ->get();
        
        return view('sales.dashboard', compact('clientCount', 'upcomingEventsCount', 'recentActivities'));
    }
} 