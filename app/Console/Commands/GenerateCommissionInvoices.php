<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CommissionService;
use App\Models\Partner;

class GenerateCommissionInvoices extends Command
{
    protected $signature = 'commission:generate-invoices';
    protected $description = 'Generate commission invoices for all partners every 15 days';

    public function handle(CommissionService $commissionService): int
    {
        $partners = Partner::all();
        $generated = 0;

        foreach ($partners as $partner) {
            if ($commissionService->generateInvoice($partner)) {
                $generated++;
            }
        }

        $this->info("Generated {$generated} commission invoices.");
        return 0;
    }
}