<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Distributor;
use App\Models\DailyActivity;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{
    public function index()
    {
        // Get counts
        $clientCount = Client::count();
        $distributorCount = Distributor::where('status_deleted', false)->count();
        $dailyActivityCount = DailyActivity::whereDate('created_at', today())->where('deleted_status', false)->count(); 
        
        // Get recent data
        $recentClients = Client::where('status_deleted', false)->latest()->take(5)->get();
        $recentDistributors = Distributor::where('status_deleted', false)->latest()->take(5)->get();
        $recentActivities = DailyActivity::with('creator')->latest()->take(5)->get();
        
        // Get recent logs from ActivityLog table
        $recentLogs = ActivityLog::with('user')->latest()->take(5)->get();
        
        return view('admin.dashboard', compact(
            'clientCount',
            'distributorCount', 
            'dailyActivityCount',
            'recentClients',
            'recentDistributors',
            'recentActivities',
            'recentLogs'
        ));
    }
    
    public function logs()
    {
        // Ambil log dari tabel activity_logs, terbaru dulu, beserta user
        $allLogs = ActivityLog::with('user')->latest()->paginate(50);
        return view('admin.logs', compact('allLogs'));
    }
    
    private function getRecentLogs()
    {
        $logFile = storage_path('logs/laravel.log');
        $parsedLogs = [];
        
        if (file_exists($logFile)) {
            $logContent = file_get_contents($logFile);
            $lines = explode("\n", $logContent);
            
            foreach (array_reverse($lines) as $line) {
                // Look for relevant activity logs
                if (strpos($line, 'local.INFO') !== false && 
                    (strpos($line, 'Distributor') !== false || 
                     strpos($line, 'Client') !== false || 
                     strpos($line, 'DailyActivity') !== false ||
                     strpos($line, 'User') !== false)) {
                    
                    // Extract timestamp
                    preg_match('/\[(.*?)\]/', $line, $timestampMatch);
                    $timestamp = $timestampMatch[1] ?? '';
                    
                    // Extract JSON data
                    if (preg_match('/\{.*\}/', $line, $jsonMatch)) {
                        $jsonData = json_decode($jsonMatch[0], true);
                        if ($jsonData) {
                            $action = $jsonData['action'] ?? '';
                            $userName = $jsonData['user_name'] ?? '';
                            
                            // Determine entity type and name
                            $entityType = '';
                            $entityName = '';
                            
                            if (isset($jsonData['distributor_name'])) {
                                $entityType = 'Distributor';
                                $entityName = $jsonData['distributor_name'];
                            } elseif (isset($jsonData['client_name'])) {
                                $entityType = 'Client';
                                $entityName = $jsonData['client_name'];
                            } elseif (isset($jsonData['activity_name'])) {
                                $entityType = 'Aktivitas';
                                $entityName = $jsonData['activity_name'];
                            } elseif (isset($jsonData['user_name'])) {
                                $entityType = 'User';
                                $entityName = $jsonData['user_name'];
                            }
                            
                            // Create clean message
                            $message = '';
                            if ($action === 'create') {
                                $message = "{$entityType} '{$entityName}' berhasil dibuat";
                            } elseif ($action === 'update') {
                                $message = "{$entityType} '{$entityName}' berhasil diperbarui";
                            } elseif ($action === 'delete') {
                                $message = "{$entityType} '{$entityName}' berhasil dihapus";
                            }
                            
                            if ($message) {
                                $parsedLogs[] = [
                                    'timestamp' => $timestamp,
                                    'message' => $message,
                                    'action' => $action,
                                    'entity_type' => $entityType,
                                    'entity_name' => $entityName,
                                    'user_name' => $userName
                                ];
                            }
                        }
                    }
                }
                
                if (count($parsedLogs) >= 10) {
                    break;
                }
            }
        }
        
        return $parsedLogs;
    }
    
    private function getAllLogs()
    {
        $logFile = storage_path('logs/laravel.log');
        $parsedLogs = [];
        
        if (file_exists($logFile)) {
            $logContent = file_get_contents($logFile);
            $lines = explode("\n", $logContent);
            
            foreach (array_reverse($lines) as $line) {
                if (trim($line) === '') continue;
                // Only show INFO or ERROR logs
                if (strpos($line, 'local.INFO') !== false || strpos($line, 'local.ERROR') !== false) {
                    // Extract timestamp
                    preg_match('/\[(.*?)\]/', $line, $timestampMatch);
                    $timestamp = $timestampMatch[1] ?? '';
                    
                    // Try to extract JSON data
                    if (preg_match('/\{.*\}/', $line, $jsonMatch)) {
                        $jsonData = json_decode($jsonMatch[0], true);
                        if ($jsonData && isset($jsonData['action'])) {
                            $action = $jsonData['action'] ?? '';
                            $userName = $jsonData['user_name'] ?? '';
                            $entityType = '';
                            $entityName = '';
                            if (isset($jsonData['distributor_name'])) {
                                $entityType = 'Distributor';
                                $entityName = $jsonData['distributor_name'];
                            } elseif (isset($jsonData['client_name'])) {
                                $entityType = 'Client';
                                $entityName = $jsonData['client_name'];
                            } elseif (isset($jsonData['activity_name'])) {
                                $entityType = 'Aktivitas';
                                $entityName = $jsonData['activity_name'];
                            } elseif (isset($jsonData['user_name'])) {
                                $entityType = 'User';
                                $entityName = $jsonData['user_name'];
                            }
                            $message = '';
                            if ($action === 'create') {
                                $message = "{$entityType} '{$entityName}' berhasil dibuat";
                            } elseif ($action === 'update') {
                                $message = "{$entityType} '{$entityName}' berhasil diperbarui";
                            } elseif ($action === 'delete') {
                                $message = "{$entityType} '{$entityName}' berhasil dihapus";
                            }
                            if ($message) {
                                $parsedLogs[] = [
                                    'timestamp' => $timestamp,
                                    'message' => $message,
                                    'action' => $action,
                                    'entity_type' => $entityType,
                                    'entity_name' => $entityName,
                                    'user_name' => $userName,
                                    'is_json' => true
                                ];
                                continue;
                            }
                        }
                    }
                    // If not JSON or not our format, show raw log
                    // Extract main message after log level
                    $mainMsg = $line;
                    if (preg_match('/local\.(INFO|ERROR): (.*)/', $line, $msgMatch)) {
                        $mainMsg = $msgMatch[2];
                    }
                    $parsedLogs[] = [
                        'timestamp' => $timestamp,
                        'message' => $mainMsg,
                        'action' => '',
                        'entity_type' => '',
                        'entity_name' => '',
                        'user_name' => '',
                        'is_json' => false
                    ];
                }
                if (count($parsedLogs) >= 100) break;
            }
        }
        return $parsedLogs;
    }
} 