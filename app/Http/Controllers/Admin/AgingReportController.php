<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AgingReportService;
use App\View\Admin\AgingReportViewModel;
use Illuminate\Http\Request;

class AgingReportController extends Controller
{
    public function __construct(
        private AgingReportService $agingReportService
    ) {}

    public function __invoke(Request $request)
    {
        $data = $this->agingReportService->getAgingReportData($request);
        $viewModel = new AgingReportViewModel($data);

        return view('admin.aging-report', $viewModel->toArray());
    }
}