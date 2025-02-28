<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Cek guard admin
        if ($role === 'admin') {
            if (!Auth::guard('admin')->check()) {
                return redirect()->route('admin.login')
                    ->with('error', 'Please login as admin first');
            }
            return $next($request);
        }

        // Cek guard web (user regular)
        if ($role === 'user') {
            if (!Auth::guard('web')->check()) {
                return redirect()->route('login')
                    ->with('error', 'Please login first');
            }
            return $next($request);
        }

        // Jika role tidak dikenali
        return redirect()->back()
            ->with('error', 'Unauthorized access');
    }
}