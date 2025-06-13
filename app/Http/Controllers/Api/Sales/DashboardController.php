<?php

namespace App\Http\Controllers\Api\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Client;
use App\Models\DailyActivity;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function stats()
    {
        $user = Auth::user();
        
        // Get upcoming events count
        $upcomingEventsCount = Event::where('jadwal', '>=', now())
            ->where('status', 'active')
            ->where('status_deleted', false)
            ->count();
            
        // Get client count for the current user
        $clientCount = Client::where('created_by', $user->id)
            ->where('status_deleted', false)
            ->count();
        
        return response()->json([
            'upcomingEventsCount' => $upcomingEventsCount,
            'clientCount' => $clientCount,
        ]);
    }
} 