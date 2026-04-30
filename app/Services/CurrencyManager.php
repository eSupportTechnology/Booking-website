<?php

namespace App\Services;

use Illuminate\Support\Facades\Cookie;

class CurrencyManager
{
    public function getUserCurrency(): string
    {
        // Force USD for partner panel
        if (request()->is('partner/*') || request()->routeIs('partner.*')) {
            return 'USD';
        }

        // Try session first, then cookie, then default
        $currency = session('currency');

        if (!$currency) {
            $currency = request()->cookie('user_currency');
        }

        return $currency ?: $this->getDefaultCurrency();
    }

    public function setUserCurrency(string $currency): void
    {
        // Store in both session and cookie for reliability
        session(['currency' => $currency]);
        Cookie::queue('user_currency', $currency, 60 * 24 * 30); // 30 days
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
