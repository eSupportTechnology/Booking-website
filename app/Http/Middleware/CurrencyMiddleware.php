<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\CurrencyManager;

class CurrencyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Set default currency if not set
        if (!session()->has('currency')) {
            $currencyManager = app(CurrencyManager::class);
            session(['currency' => $currencyManager->getDefaultCurrency()]);
        }

        return $next($request);
    }
}