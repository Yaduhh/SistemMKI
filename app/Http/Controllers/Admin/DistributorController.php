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

        // Log activity with cleaner format
        Log::info("Distributor '{$distributor->nama_distributor}' created by " . auth()->user()->name, [
            'action' => 'create',
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'distributor_id' => $distributor->id,
            'distributor_name' => $distributor->nama_distributor
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

        $oldStatus = $distributor->status;
        $distributor->update($data);

        // Log activity with cleaner format
        Log::info("Distributor '{$distributor->nama_distributor}' updated by " . auth()->user()->name, [
            'action' => 'update',
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'distributor_id' => $distributor->id,
            'distributor_name' => $distributor->nama_distributor,
            'old_status' => $oldStatus,
            'new_status' => $data['status']
        ]);

        return redirect()->route('admin.distributor.index')
            ->with('success', 'Distributor berhasil diperbarui');
    }

    public function destroy(Distributor $distributor)
    {
        // Log activity before deletion
        Log::info("Distributor '{$distributor->nama_distributor}' deleted by " . auth()->user()->name, [
            'action' => 'delete',
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'distributor_id' => $distributor->id,
            'distributor_name' => $distributor->nama_distributor
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
                // Look for distributor activity logs
                if (strpos($line, 'Distributor') !== false && 
                    (strpos($line, 'created') !== false || 
                     strpos($line, 'updated') !== false || 
                     strpos($line, 'deleted') !== false)) {
                    
                    // Extract timestamp
                    preg_match('/\[(.*?)\]/', $line, $timestampMatch);
                    $timestamp = $timestampMatch[1] ?? '';
                    
                    // Extract JSON data first
                    if (preg_match('/\{.*\}/', $line, $jsonMatch)) {
                        $jsonData = json_decode($jsonMatch[0], true);
                        if ($jsonData) {
                            // Create clean message based on action
                            $action = $jsonData['action'] ?? '';
                            $distributorName = $jsonData['distributor_name'] ?? '';
                            $userName = $jsonData['user_name'] ?? '';
                            
                            $message = '';
                            if ($action === 'create') {
                                $message = "Distributor '{$distributorName}' berhasil dibuat";
                            } elseif ($action === 'update') {
                                $message = "Distributor '{$distributorName}' berhasil diperbarui";
                            } elseif ($action === 'delete') {
                                $message = "Distributor '{$distributorName}' berhasil dihapus";
                            }
                            
                            if ($message) {
                                $parsedLogs[] = [
                                    'timestamp' => $timestamp,
                                    'message' => $message,
                                    'action' => $action,
                                    'user_name' => $userName,
                                    'distributor_name' => $distributorName,
                                    'distributor_id' => $jsonData['distributor_id'] ?? '',
                                    'old_status' => $jsonData['old_status'] ?? null,
                                    'new_status' => $jsonData['new_status'] ?? null
                                ];
                            }
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