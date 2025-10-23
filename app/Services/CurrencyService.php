<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\ExchangeRate;
use Exception;
use Carbon\Carbon;

class CurrencyService
{
    private array $supportedCurrencies = ['USD', 'EUR', 'GBP', 'LKR'];
    private const RATE_EXPIRY_MINUTES = 60;
    private const CACHE_PREFIX = 'currency_rate_';
    
    // Fallback rates in case API fails (updated as of Oct 2025)
    private array $fallbackRates = [
        'USD' => [
            'EUR' => 0.94,
            'GBP' => 0.82,
            'LKR' => 324.85
        ],
        'EUR' => [
            'USD' => 1.06,
            'GBP' => 0.87,
            'LKR' => 344.93
        ],
        'GBP' => [
            'USD' => 1.22,
            'EUR' => 1.15,
            'LKR' => 396.16
        ],
        'LKR' => [
            'USD' => 0.0031,
            'EUR' => 0.0029,
            'GBP' => 0.0025
        ]
    ];
    
    public function convert($amount, string $from, string $to): float
    {
        // Ensure amount is a float
        $amount = (float) $amount;
        
        if ($from === $to) return $amount;
        
        $rate = $this->getRate($from, $to);
        return round($amount * $rate, 2);
    }
    
    public function getRate(string $from, string $to): float
    {
        // First try to get from cache for immediate response
        $cacheKey = "rate_{$from}_{$to}";
        $cachedRate = Cache::get($cacheKey);
        
        if ($cachedRate !== null) {
            return $cachedRate;
        }
        
        // Then check database
        $rate = $this->getStoredRate($from, $to);
        
        if ($rate === null) {
            // If no valid rate found, fetch new rates
            $this->fetchLatestRates($from);
            $rate = $this->getStoredRate($from, $to) ?? 1.0;
        }
        
        // Cache the rate for quick access
        Cache::put($cacheKey, $rate, now()->addMinutes(5));
        
        return $rate;
    }
    
    private function getStoredRate(string $from, string $to): ?float
    {
        return ExchangeRate::where('from_currency', $from)
            ->where('to_currency', $to)
            ->where('cached_at', '>', now()->subMinutes(self::RATE_EXPIRY_MINUTES))
            ->value('rate');
    }
    
    public function fetchLatestRates(string $baseCurrency): void
    {
        try {
            // Use the configured HTTP client with proper SSL certificate
            $response = Http::exchangeApi()
                ->get("https://api.exchangerate-api.com/v4/latest/{$baseCurrency}");
            
            if (!$response->successful()) {
                throw new Exception("Failed to fetch rates for {$baseCurrency}. Status: " . $response->status());
            }
            
            $data = $response->json();
            $rates = $data['rates'] ?? [];
            
            if (empty($rates)) {
                throw new Exception("No rates returned for {$baseCurrency}");
            }
            
            // Begin transaction for atomic update
            DB::transaction(function () use ($baseCurrency, $rates) {
                $timestamp = now();
                
                foreach ($rates as $toCurrency => $rate) {
                    if (!in_array($toCurrency, $this->supportedCurrencies)) {
                        continue;
                    }
                    
                    ExchangeRate::updateOrCreate(
                        ['from_currency' => $baseCurrency, 'to_currency' => $toCurrency],
                        ['rate' => $rate, 'cached_at' => $timestamp]
                    );
                    
                    // Also create inverse rate
                    if ($rate > 0) {
                        ExchangeRate::updateOrCreate(
                            ['from_currency' => $toCurrency, 'to_currency' => $baseCurrency],
                            ['rate' => 1 / $rate, 'cached_at' => $timestamp]
                        );
                    }
                }
            });
            
            // Clear related caches
            $this->clearRateCache($baseCurrency);
            
        } catch (Exception $e) {
            Log::error('Currency API error: ' . $e->getMessage());
            throw $e;
        }
    }
    
    private function clearRateCache(string $currency): void
    {
        foreach ($this->supportedCurrencies as $otherCurrency) {
            Cache::forget("rate_{$currency}_{$otherCurrency}");
            Cache::forget("rate_{$otherCurrency}_{$currency}");
        }
    }
    
    public function getCurrencySymbol(string $currency): string
    {
        return match ($currency) {
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'LKR' => 'Rs',
            default => $currency
        };
    }
    
    public function formatPriceWithSymbol($amount, string $currency): string
    {
        $symbol = $this->getCurrencySymbol($currency);
        $formattedAmount = number_format((float) $amount, 2);
        
        return match ($currency) {
            'LKR' => "Rs {$formattedAmount}",  // Sri Lankan Rupee symbol goes before with space
            default => $symbol . $formattedAmount  // Most currencies have symbol before without space
        };
    }
    
    public function getSupportedCurrencies(): array
    {
        return $this->supportedCurrencies;
    }

    public function formatPrice(float $amount, string $currency): string
    {
        $symbols = ['USD' => '$', 'EUR' => '€', 'GBP' => '£', 'LKR' => 'Rs'];
        $symbol = $symbols[$currency] ?? $currency;

        return $symbol . number_format($amount, 2);
    }
}
