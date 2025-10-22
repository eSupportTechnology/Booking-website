<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\ExchangeRate;
use Illuminate\Support\Facades\Log;

class CurrencyService
{
    private array $supportedCurrencies = ['USD', 'EUR', 'GBP', 'LKR'];
    
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
        $cacheKey = "rate_{$from}_{$to}";
        
        return Cache::remember($cacheKey, 3600, function () use ($from, $to) {
            // Try database first
            $cached = ExchangeRate::where('from_currency', $from)
                ->where('to_currency', $to)
                ->where('cached_at', '>', now()->subHour())
                ->first();
                
            if ($cached) return $cached->rate;
            
            // Fetch from API
            try {
                $response = Http::timeout(10)->get("https://api.exchangerate-api.com/v4/latest/{$from}");
                
                if ($response->successful()) {
                    $data = $response->json();
                    $rate = $data['rates'][$to] ?? 1.0;
                    
                    // Cache in database
                    ExchangeRate::updateOrCreate(
                        ['from_currency' => $from, 'to_currency' => $to],
                        ['rate' => $rate, 'cached_at' => now()]
                    );
                    
                    return $rate;
                }
            } catch (\Exception $e) {
                Log::error('Currency API error: ' . $e->getMessage());
            }
            
            return 1.0;
        });
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