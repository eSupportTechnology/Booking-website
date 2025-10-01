<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Services\CommissionService;
use Illuminate\Http\Request;

class PartnerCommissionController extends Controller
{
    public function __construct(
        private CommissionService $commissionService
    ) {}

    public function index()
    {
        $partners = Partner::with(['user', 'settings'])->paginate(15);
        $globalCommissionRate = $this->commissionService->getGlobalCommissionRate();
        
        return view('admin.commission.index', compact('partners', 'globalCommissionRate'));
    }

    public function updatePartnerCommission(Request $request, Partner $partner)
    {
        $request->validate([
            'commission_rate' => 'nullable|numeric|min:0|max:1'
        ]);

        $this->commissionService->setPartnerCommissionRate(
            $partner, 
            $request->commission_rate ?: null
        );

        return back()->with('success', 'Partner commission rate updated successfully.');
    }

    public function removePartnerCommission(Partner $partner)
    {
        $this->commissionService->removePartnerCommissionRate($partner);
        
        return back()->with('success', 'Partner commission rate removed. Using global rate.');
    }
}