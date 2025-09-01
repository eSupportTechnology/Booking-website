<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartnerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->hasRole('partner')) {
            return redirect()->route('partner.login')->with('error', 'Access denied. Partner access required.');
        }

        return $next($request);
    }
}