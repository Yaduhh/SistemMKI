<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Services\ActivityLogService;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with('creator')->notDeleted()->orderBy('jadwal', 'desc')->get();
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('admin.events.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Convert peserta from JSON string to array if needed
        $peserta = $request->peserta;
        if (is_string($peserta)) {
            $peserta = json_decode($peserta, true) ?? [];
        }

        $validator = Validator::make([
            'nama_event' => $request->nama_event,
            'jadwal' => $request->jadwal,
            'location' => $request->location,
            'deskripsi' => $request->deskripsi,
            'peserta' => $peserta,
            'status' => $request->status
        ], [
            'nama_event' => 'required|string|max:255',
            'jadwal' => 'required|date',
            'location' => 'nullable|string|max:500',
            'deskripsi' => 'nullable|string',
            'peserta' => 'required|array|min:1',
            'peserta.*' => 'exists:users,id',
            'status' => 'nullable|in:active,cancelled,completed'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $event = Event::create([
            'nama_event' => $request->nama_event,
            'jadwal' => $request->jadwal,
            'location' => $request->location,
            'deskripsi' => $request->deskripsi,
            'peserta' => $peserta,
            'status' => $request->status ?? 'active',
            'status_deleted' => false,
            'created_by' => Auth::id()
        ]);

        // Log create
        ActivityLogService::logCreate('Event', 'Membuat event: ' . $event->nama_event, $event->toArray());

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load('creator');
        $invitedUsers = User::whereIn('id', $event->peserta)->get();
        return view('admin.events.show', compact('event', 'invitedUsers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $users = User::all();
        return view('admin.events.edit', compact('event', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        // Convert peserta from JSON string to array if needed
        $peserta = $request->peserta;
        if (is_string($peserta)) {
            $peserta = json_decode($peserta, true) ?? [];
        }

        $validator = Validator::make([
            'nama_event' => $request->nama_event,
            'jadwal' => $request->jadwal,
            'location' => $request->location,
            'deskripsi' => $request->deskripsi,
            'peserta' => $peserta,
            'status' => $request->status
        ], [
            'nama_event' => 'required|string|max:255',
            'jadwal' => 'required|date',
            'location' => 'nullable|string|max:500',
            'deskripsi' => 'nullable|string',
            'peserta' => 'required|array|min:1',
            'peserta.*' => 'exists:users,id',
            'status' => 'required|in:active,cancelled,completed'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $oldData = $event->toArray();
        $event->update([
            'nama_event' => $request->nama_event,
            'jadwal' => $request->jadwal,
            'location' => $request->location,
            'deskripsi' => $request->deskripsi,
            'peserta' => $peserta,
            'status' => $request->status
        ]);

        // Log update
        ActivityLogService::logUpdate('Event', 'Mengubah event: ' . $event->nama_event, $oldData, $event->toArray());

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $oldData = $event->toArray();
        $event->softDelete();
        // Log delete
        ActivityLogService::logDelete('Event', 'Menghapus event: ' . $event->nama_event, $oldData);
        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil dihapus!');
    }

    /**
     * Get upcoming events.
     */
    public function upcoming()
    {
        $events = Event::with('creator')->active()->upcoming()->orderBy('jadwal', 'asc')->get();
        return view('admin.events.upcoming', compact('events'));
    }

    /**
     * Get past events.
     */
    public function past()
    {
        $events = Event::with('creator')->notDeleted()->past()->orderBy('jadwal', 'desc')->get();
        return view('admin.events.past', compact('events'));
    }

    /**
     * Get cancelled events.
     */
    public function cancelled()
    {
        $events = Event::with('creator')->notDeleted()->where('status', 'cancelled')->orderBy('jadwal', 'desc')->get();
        return view('admin.events.cancelled', compact('events'));
    }

    /**
     * Get completed events.
     */
    public function completed()
    {
        $events = Event::with('creator')->notDeleted()->where('status', 'completed')->orderBy('jadwal', 'desc')->get();
        return view('admin.events.completed', compact('events'));
    }

    /**
     * Get deleted events.
     */
    public function deleted()
    {
        $events = Event::with('creator')->where('status_deleted', true)->orderBy('jadwal', 'desc')->get();
        return view('admin.events.deleted', compact('events'));
    }

    /**
     * Restore a deleted event.
     */
    public function restore($id)
    {
        $event = Event::findOrFail($id);
        $oldData = $event->toArray();
        $event->restore();
        // Log restore
        ActivityLogService::log('RESTORE', 'Event', 'Memulihkan event: ' . $event->nama_event, $oldData, $event->toArray());
        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil dipulihkan!');
    }

    /**
     * Permanently delete an event.
     */
    public function forceDelete($id)
    {
        $event = Event::findOrFail($id);
        $event->delete(); // This will permanently delete the record
        return redirect()->route('admin.events.deleted')
            ->with('success', 'Event berhasil dihapus permanen!');
    }

    /**
     * Update event status.
     */
    public function updateStatus(Request $request, Event $event)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:active,cancelled,completed'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $oldData = $event->toArray();
        $event->update(['status' => $request->status]);

        // Log status update
        ActivityLogService::logUpdate('Event', 'Mengubah status event: ' . $event->nama_event, $oldData, $event->toArray());

        $statusMessages = [
            'active' => 'Event berhasil diaktifkan!',
            'cancelled' => 'Event berhasil dibatalkan!',
            'completed' => 'Event berhasil diselesaikan!'
        ];

        return redirect()->back()
            ->with('success', $statusMessages[$request->status]);
    }
} 