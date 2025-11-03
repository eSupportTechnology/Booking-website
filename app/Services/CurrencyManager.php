<?php

namespace App\Services;

class CurrencyManager
{
    public function getUserCurrency(): string
    {
        // Force USD for partner panel
        if (request()->is('partner/*') || request()->routeIs('partner.*')) {
            return 'USD';
        }
        
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
            'inselor.de' => 'LKR',
            'bookintour.lk' => 'LKR',
            default => 'USD'
        };
    }
}
