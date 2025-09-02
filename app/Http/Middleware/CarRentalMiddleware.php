<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarRenterMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is logged in AND is a car renter
        if (Auth::guard('car_renter')->check()) {
            return $next($request);
        }

        // Redirect to login if not authorized
        return redirect()->route('carrentals.login')->withErrors([
            'auth' => 'You must be logged in as a Car Renter to access this page.'
        ]);
    }
}
