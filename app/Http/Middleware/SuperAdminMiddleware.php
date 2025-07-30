<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->hasRole('super-admin')) {
            return $next($request);
        }

        return redirect()->route('admin.dashboard')->with('error', 'Super admin access required');
    }
}