<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\CommissionInvoice;
use App\Services\CommissionService;
use Illuminate\Http\Request;

class PartnerCommissionController extends Controller
{
    public function __construct(
        private CommissionService $commissionService
    ) {}

    public function agingReport()
    {
        $report = $this->commissionService->getAgingReport();
        return view('admin.commission.aging', compact('report'));
    }

    public function markPaid(CommissionInvoice $invoice)
    {
        $invoice->markAsPaid();
        return back()->with('success', 'Invoice marked as paid.');
    }

    public function generateInvoices()
    {
        $partners = Partner::all();
        $generated = 0;
        
        foreach ($partners as $partner) {
            if ($this->commissionService->generateInvoice($partner)) {
                $generated++;
            }
        }
        
        return back()->with('success', "Generated {$generated} invoices.");
    }

    public function deactivateOverdue()
    {
        $count = $this->commissionService->deactivateOverduePartners();
        return back()->with('success', "Deactivated properties for {$count} partners.");
    }
}