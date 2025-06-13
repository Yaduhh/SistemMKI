<?php

namespace App\Http\Controllers\Api\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $clients = Client::where('created_by', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json([
            'data' => $clients
        ]);
    }
    
    public function show(Client $client)
    {
        $user = Auth::user();
        
        // Check if the client belongs to the current user
        if ($client->created_by !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        return response()->json([
            'data' => $client
        ]);
    }
} 