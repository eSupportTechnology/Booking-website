<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidatePartnerData
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('partner.login');
        }

        if (!auth()->user()->hasRole('partner')) {
            abort(403, 'Access denied. Partner role required.');
        }

        return $next($request);
    }
}