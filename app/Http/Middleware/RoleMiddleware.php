<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Cek apakah pengguna terautentikasi dan memiliki role sesuai
        if (Auth::check() && Auth::user()->role == (int)$role) {
            return $next($request);
        }

        // Jika request adalah API, return JSON response
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Unauthorized. Insufficient permissions.',
                'error' => 'Forbidden'
            ], 403);
        }

        // Jika request adalah web, redirect
        return redirect()->route('dashboard');
    }
}
