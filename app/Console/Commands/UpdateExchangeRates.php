<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CurrencyService;

class UpdateExchangeRates extends Command
{
    protected $signature = 'currency:update-rates';
    protected $description = 'Update exchange rates for all supported currencies';

    public function handle(CurrencyService $currencyService)
    {
        $this->info('Starting exchange rates update...');

        $baseCurrencies = ['USD', 'EUR', 'GBP', 'LKR'];
        $errors = [];

        foreach ($baseCurrencies as $currency) {
            try {
                $this->info("Fetching rates for {$currency}...");
                $currencyService->fetchLatestRates($currency);
                $this->info("✓ Updated rates for {$currency}");
            } catch (\Exception $e) {
                $errors[] = "{$currency}: " . $e->getMessage();
                $this->error("✗ Failed to update rates for {$currency}");
            }
        }

        if (!empty($errors)) {
            $this->error("\nErrors encountered:");
            foreach ($errors as $error) {
                $this->error("- {$error}");
            }
            return 1;
        }

        $this->info("\nAll exchange rates updated successfully!");
        return 0;
    }
}
