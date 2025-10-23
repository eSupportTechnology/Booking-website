<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\GenerateCommissionInvoices::class,
        Commands\DeactivateOverduePartners::class,
        Commands\CancelExpiredBookings::class,
        Commands\UpdateExchangeRates::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        // Generate commission invoices every 15 days
        $schedule->command('commission:generate-invoices')->dailyAt('09:00');
        
        // Check for overdue payments and deactivate properties daily
        $schedule->command('commission:deactivate-overdue')->dailyAt('10:00');
        
        // Cancel expired bookings every hour
        $schedule->command('bookings:cancel-expired')->hourly();
        
        // Update currency exchange rates every hour
        $schedule->command('currency:update-rates')
            ->hourly()
            ->withoutOverlapping()
            ->onFailure(function () {
                Log::error('Failed to update exchange rates');
            });
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}