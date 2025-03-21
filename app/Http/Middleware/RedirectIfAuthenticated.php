<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if ($guard === 'admin') {
                    $user = Auth::guard('admin')->user();
                    
                    if ($user->role === 'pimpinan') {
                        return redirect('/pimpinan');
                    }
                    
                    return redirect('/admin');
                }
                return redirect('/user');
            }
        }

        return $next($request);
    }
}