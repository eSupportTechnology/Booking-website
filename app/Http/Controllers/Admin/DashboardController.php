<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DashboardService;
use App\View\Admin\DashboardViewModel;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService
    ) {}

    public function __invoke(Request $request)
    {
        $data = $this->dashboardService->getDashboardData($request);
        $viewModel = new DashboardViewModel($data);

        return view('admin.admin-dashboard', $viewModel->toArray());
    }
}
