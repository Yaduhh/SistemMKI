<?php

namespace App\Http\Controllers\Api\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function upcoming()
    {
        $events = Event::where('jadwal', '>=', now())
            ->where('status', 'active')
            ->where('status_deleted', false)
            ->orderBy('jadwal', 'asc')
            ->get();
            
        return response()->json([
            'data' => $events
        ]);
    }
    
    public function myUpcoming()
    {
        $user = Auth::user();
        
        // Get events where the user is in the peserta array
        $events = Event::where('jadwal', '>=', now())
            ->where('status', 'active')
            ->where('status_deleted', false)
            ->whereJsonContains('peserta', $user->id)
            ->orderBy('jadwal', 'asc')
            ->get();
            
        return response()->json([
            'data' => $events
        ]);
    }
    
    public function past()
    {
        $events = Event::where('jadwal', '<', now())
            ->where('status_deleted', false)
            ->orderBy('jadwal', 'desc')
            ->get();
            
        return response()->json([
            'data' => $events
        ]);
    }
    
    public function stats()
    {
        $totalEvents = Event::where('status_deleted', false)->count();
        $upcomingEvents = Event::where('jadwal', '>=', now())->where('status_deleted', false)->count();
        $pastEvents = Event::where('jadwal', '<', now())->where('status_deleted', false)->count();
        $activeEvents = Event::where('status', 'active')->where('status_deleted', false)->count();
        
        return response()->json([
            'totalEvents' => $totalEvents,
            'upcomingEvents' => $upcomingEvents,
            'pastEvents' => $pastEvents,
            'activeEvents' => $activeEvents,
        ]);
    }
} 