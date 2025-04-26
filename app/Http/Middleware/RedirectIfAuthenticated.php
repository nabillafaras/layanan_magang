<?php
// app/Http/Middleware/RedirectIfAuthenticated.php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if ($guard === 'admin') {
                    $user = Auth::guard('admin')->user();
                    
                    if ($user->role === 'admin') {
                        return redirect()->route('admin.dashboard');
                    } elseif ($user->role === 'pimpinan') {
                        return redirect()->route('pimpinan.dashboard');
                    } elseif ($user->role === 'admin1') {
                        return redirect()->route('admin1.dashboard');
                    } elseif ($user->role === 'admin2') {
                        return redirect()->route('admin2.dashboard');
                    } elseif ($user->role === 'admin3') {
                        return redirect()->route('admin3.dashboard');
                    } elseif ($user->role === 'admin4') {
                        return redirect()->route('admin4.dashboard');
                    } elseif ($user->role === 'admin5') {
                        return redirect()->route('admin5.dashboard');
                    }

                    return redirect('/admin');
                }
                return redirect('/user');
            }
        }
    
        return $next($request);
    }
}
                
                
