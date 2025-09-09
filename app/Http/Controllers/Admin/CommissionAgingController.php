<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\CommissionAgingService;
use App\View\Admin\CommissionAgingViewModel;
use Illuminate\Http\Request;

class CommissionAgingController extends Controller
{
    public function __construct(
        private CommissionAgingService $commissionAgingService
    ) {}

    public function __invoke(Request $request)
    {
        $data = $this->commissionAgingService->getCommissionAgingData($request);
        $viewModel = new CommissionAgingViewModel($data);

        return view('admin.commission-aging', $viewModel->toArray());
    }
}