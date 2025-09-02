<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarRenterMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('car_renter')->check()) {
            return $next($request);
        }

        return redirect()->route('carrentals.login.email')->withErrors([
            'auth' => 'You must be logged in as a Car Renter to access this page.'
        ]);
    }
}
