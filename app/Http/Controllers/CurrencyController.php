<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Services\CurrencyManager;
use App\Services\CurrencyService;

class CurrencyController extends Controller
{
    public function setCurrency(Request $request)
    {
        $validated = $request->validate([
            'currency' => 'required|in:USD,EUR,GBP,LKR'
        ]);

        $currency = $validated['currency'];

        // Set via CurrencyManager (handles both session and cookie)
        app(CurrencyManager::class)->setUserCurrency($currency);

        // Return response with cookie attached
        return response()->json([
            'success' => true,
            'currency' => $currency
        ])->withCookie(cookie('user_currency', $currency, 60 * 24 * 30));
    }

    public function getRate(string $from, string $to)
    {
        $rate = app(CurrencyService::class)->getRate($from, $to);

        return response()->json(['rate' => $rate]);
    }
}