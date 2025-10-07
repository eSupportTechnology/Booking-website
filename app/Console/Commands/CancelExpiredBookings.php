<?php

namespace App\Console\Commands;

use App\Jobs\CancelUnpaidBookingsJob;
use Illuminate\Console\Command;

class CancelExpiredBookings extends Command
{
    protected $signature = 'bookings:cancel-expired';
    protected $description = 'Cancel bookings that have exceeded payment deadline';

    public function handle()
    {
        CancelUnpaidBookingsJob::dispatch();
        $this->info('Expired bookings cancellation job dispatched.');
    }
}