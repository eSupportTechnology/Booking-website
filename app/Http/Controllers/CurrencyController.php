<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CurrencyManager;
use App\Services\CurrencyService;

class CurrencyController extends Controller
{
    public function setCurrency(Request $request)
    {
        $validated = $request->validate([
            'currency' => 'required|in:USD,EUR,GBP,LKR'
        ]);
        
        app(CurrencyManager::class)->setUserCurrency($validated['currency']);
        
        return response()->json(['success' => true]);
    }
    
    public function getRate(string $from, string $to)
    {
        $rate = app(CurrencyService::class)->getRate($from, $to);
        
        return response()->json(['rate' => $rate]);
    }
}