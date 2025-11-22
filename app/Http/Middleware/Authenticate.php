<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request): ?string
{
    // dd('RedirectTo function called', $request->path());
    if (!$request->expectsJson()) {
        if ($request->is('admin') || $request->is('admin/*')) {
            return route('admin.login');
        }
        if ($request->is('partner') || $request->is('partner/*')) {
            return route('partner.login');
        }

        // Customer redirect
        if ($request->is('customer') || $request->is('customer/*')) {
            return url('/customer/login');
        }
        return route('choose-option');
    }
}

}
