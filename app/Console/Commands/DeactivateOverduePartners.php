<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CommissionService;

class DeactivateOverduePartners extends Command
{
    protected $signature = 'commission:deactivate-overdue';
    protected $description = 'Deactivate properties for partners with overdue commission payments';

    public function handle(CommissionService $commissionService): int
    {
        $count = $commissionService->deactivateOverduePartners();
        $this->info("Deactivated properties for {$count} overdue partners.");
        return 0;
    }
}