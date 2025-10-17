<?php

namespace App\Helpers;

use App\Services\CurrencyService;
use App\Services\CurrencyManager;

class CurrencyHelper
{
    public static function formatPrice($amount, $currency = null)
    {
        $currency = $currency ?? app(CurrencyManager::class)->getUserCurrency();
        return app(CurrencyService::class)->formatPrice($amount, $currency);
    }
    
    public static function convertPrice($amount, $fromCurrency, $toCurrency = null)
    {
        $toCurrency = $toCurrency ?? app(CurrencyManager::class)->getUserCurrency();
        return app(CurrencyService::class)->convert($amount, $fromCurrency, $toCurrency);
    }
    
    public static function convertAndFormat($amount, $fromCurrency, $toCurrency = null)
    {
        $toCurrency = $toCurrency ?? app(CurrencyManager::class)->getUserCurrency();
        $converted = app(CurrencyService::class)->convert($amount, $fromCurrency, $toCurrency);
        return app(CurrencyService::class)->formatPrice($converted, $toCurrency);
    }
}