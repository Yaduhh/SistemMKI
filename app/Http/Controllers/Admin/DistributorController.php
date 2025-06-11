<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DistributorController extends Controller
{
    public function index()
    {
        $distributors = Distributor::where('status_deleted', false)->get();
        return view('admin.distributor.index', compact('distributors'));
    }

    public function create()
    {
        return view('admin.distributor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_distributor' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'boolean'
        ]);

        $data = $request->all();
        $data['status'] = $request->has('status') ? true : false;

        if ($request->hasFile('profile')) {
            $profile = $request->file('profile');
            $profilePath = $profile->store('distributor-profiles', 'public');
            $data['profile'] = $profilePath;
        }

        $distributor = Distributor::create($data);

        // Log activity
        Log::info('Distributor created', [
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'distributor_id' => $distributor->id,
            'distributor_name' => $distributor->nama_distributor,
            'action' => 'create'
        ]);

        return redirect()->route('admin.distributor.index')
            ->with('success', 'Distributor berhasil ditambahkan');
    }

    public function edit(Distributor $distributor)
    {
        return view('admin.distributor.edit', compact('distributor'));
    }

    public function update(Request $request, Distributor $distributor)
    {
        $request->validate([
            'nama_distributor' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('status');
        $data['status'] = $request->has('status') ? true : false;

        if ($request->hasFile('profile')) {
            // Delete old profile if exists
            if ($distributor->profile) {
                Storage::disk('public')->delete($distributor->profile);
            }
            
            $profile = $request->file('profile');
            $profilePath = $profile->store('distributor-profiles', 'public');
            $data['profile'] = $profilePath;
        }

        $distributor->update($data);

        // Log activity
        Log::info('Distributor updated', [
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'distributor_id' => $distributor->id,
            'distributor_name' => $distributor->nama_distributor,
            'old_status' => $distributor->getOriginal('status'),
            'new_status' => $data['status'],
            'action' => 'update'
        ]);

        return redirect()->route('admin.distributor.index')
            ->with('success', 'Distributor berhasil diperbarui');
    }

    public function destroy(Distributor $distributor)
    {
        // Log activity before deletion
        Log::info('Distributor deleted', [
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'distributor_id' => $distributor->id,
            'distributor_name' => $distributor->nama_distributor,
            'action' => 'delete'
        ]);

        $distributor->status_deleted = true;
        $distributor->save();
        
        return redirect()->route('admin.distributor.index')
            ->with('success', 'Distributor berhasil dihapus');
    }

    public function logs()
    {
        // Get recent distributor logs from Laravel log
        $logFile = storage_path('logs/laravel.log');
        $parsedLogs = [];
        
        if (file_exists($logFile)) {
            $logContent = file_get_contents($logFile);
            $lines = explode("\n", $logContent);
            
            foreach (array_reverse($lines) as $line) {
                if (strpos($line, 'Distributor') !== false && 
                    (strpos($line, 'created') !== false || 
                     strpos($line, 'updated') !== false || 
                     strpos($line, 'deleted') !== false)) {
                    
                    // Extract timestamp
                    preg_match('/\[(.*?)\]/', $line, $timestampMatch);
                    $timestamp = $timestampMatch[1] ?? '';
                    
                    // Extract JSON data
                    preg_match('/\{.*\}/', $line, $jsonMatch);
                    if (isset($jsonMatch[0])) {
                        $jsonData = json_decode($jsonMatch[0], true);
                        if ($jsonData) {
                            $parsedLogs[] = [
                                'timestamp' => $timestamp,
                                'action' => $jsonData['action'] ?? '',
                                'user_name' => $jsonData['user_name'] ?? '',
                                'distributor_name' => $jsonData['distributor_name'] ?? '',
                                'distributor_id' => $jsonData['distributor_id'] ?? '',
                                'old_status' => $jsonData['old_status'] ?? null,
                                'new_status' => $jsonData['new_status'] ?? null,
                                'raw_line' => $line
                            ];
                        }
                    }
                }
                
                // Limit to last 50 distributor logs
                if (count($parsedLogs) >= 50) {
                    break;
                }
            }
        }
        
        return view('admin.distributor.logs', compact('parsedLogs'));
    }
} 