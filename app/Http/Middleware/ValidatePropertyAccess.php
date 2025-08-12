<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Property;

class ValidatePropertyAccess
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->route('property')) {
            $property = Property::find($request->route('property'));
            
            if (!$property || $property->user_id !== auth()->id()) {
                abort(403, 'Unauthorized access to property');
            }
        }

        return $next($request);
    }
}