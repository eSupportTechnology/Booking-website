<?php

namespace App\Helpers;

use App\Services\CurrencyService;
use App\Services\CurrencyManager;

class CurrencyHelper
{
    /**
     * Format a price in a given currency
     */
    public static function formatPrice($amount, $currency = null): string
    {
        $currency = $currency ?? app(CurrencyManager::class)->getUserCurrency();
        return app(CurrencyService::class)->formatPrice($amount, $currency);
    }

    /**
     * Convert a price from one currency to another
     */
    public static function convertPrice($amount, $fromCurrency, $toCurrency = null): float
    {
        $toCurrency = $toCurrency ?? app(CurrencyManager::class)->getUserCurrency();
        return (float) app(CurrencyService::class)->convert((float) $amount, $fromCurrency, $toCurrency);
    }

    /**
     * Convert and format a price
     */
    public static function convertAndFormat($amount, $fromCurrency, $toCurrency = null): string
    {
        $toCurrency = $toCurrency ?? app(CurrencyManager::class)->getUserCurrency();
        $converted = app(CurrencyService::class)->convert($amount, $fromCurrency, $toCurrency);
        return app(CurrencyService::class)->formatPrice($converted, $toCurrency);
    }

    /**
     * Get the symbol for a currency
     */
    public static function getSymbol(string $currency): string
    {
        return app(CurrencyService::class)->getCurrencySymbol($currency);
    }

    /**
     * Format a price with its currency symbol in the correct position
     */
    public static function formatWithSymbol($amount, $currency = null): string
    {
        $currency = $currency ?? app(CurrencyManager::class)->getUserCurrency();
        return app(CurrencyService::class)->formatPriceWithSymbol($amount, $currency);
    }
}
