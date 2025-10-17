<?php

namespace App\Services;

class CurrencyManager
{
    public function getUserCurrency(): string
    {
        return session('currency', $this->getDefaultCurrency());
    }
    
    public function setUserCurrency(string $currency): void
    {
        session(['currency' => $currency]);
    }
    
    public function getDefaultCurrency(): string
    {
        $domain = request()->getHost();
        
        return match($domain) {
            'inselor.de' => 'EUR',
            'bookintour.lk' => 'LKR',
            default => 'USD'
        };
    }
}