<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of upcoming events.
     */
    public function upcoming()
    {
        $events = Event::with('creator')
            ->active()
            ->upcoming()
            ->orderBy('jadwal', 'asc')
            ->get();

        return view('sales.events.upcoming', compact('events'));
    }

    /**
     * Display a listing of my upcoming events (where I'm invited).
     */
    public function myUpcoming()
    {
        $allUpcomingEvents = Event::with('creator')
            ->active()
            ->upcoming()
            ->orderBy('jadwal', 'asc')
            ->get();

        $events = $allUpcomingEvents->filter(function($event) {
            return in_array(Auth::id(), $event->peserta);
        });

        return view('sales.events.my-upcoming', compact('events'));
    }

    /**
     * Display a listing of past events.
     */
    public function past()
    {
        $events = Event::with('creator')
            ->notDeleted()
            ->past()
            ->orderBy('jadwal', 'desc')
            ->get();

        return view('sales.events.past', compact('events'));
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        // Check if user is invited to this event
        if (!in_array(Auth::id(), $event->peserta)) {
            abort(403, 'Anda tidak diundang ke event ini.');
        }

        $event->load('creator');
        $invitedUsers = User::whereIn('id', $event->peserta)->get();
        
        return view('sales.events.show', compact('event', 'invitedUsers'));
    }

    /**
     * Display dashboard with upcoming events for sales.
     */
    public function dashboard()
    {
        $upcomingEvents = Event::with('creator')
            ->active()
            ->upcoming()
            ->orderBy('jadwal', 'asc')
            ->limit(5)
            ->get();

        $recentPastEvents = Event::with('creator')
            ->notDeleted()
            ->past()
            ->orderBy('jadwal', 'desc')
            ->limit(5)
            ->get();

        // Get all upcoming events and filter by user invitation
        $allUpcomingEvents = Event::with('creator')
            ->active()
            ->upcoming()
            ->orderBy('jadwal', 'asc')
            ->get();

        $myUpcomingEvents = $allUpcomingEvents->filter(function($event) {
            return in_array(Auth::id(), $event->peserta);
        })->take(3);

        return view('sales.events.dashboard', compact('upcomingEvents', 'recentPastEvents', 'myUpcomingEvents'));
    }
}
