<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CurrencyService;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    private $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function convertPrice(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'from' => 'required|string|size:3',
            'to' => 'required|string|size:3'
        ]);

        $convertedAmount = $this->currencyService->convert(
            $request->amount,
            $request->from,
            $request->to
        );

        return response()->json([
            'amount' => $convertedAmount,
            'formattedPrice' => $this->currencyService->formatPriceWithSymbol($convertedAmount, $request->to)
        ]);
    }
}
