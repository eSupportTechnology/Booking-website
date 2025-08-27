<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DashboardService;
use App\View\Admin\DashboardViewModel;

class DashboardController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService
    ) {}

    public function __invoke()
    {
        $data = $this->dashboardService->getDashboardData();
        $viewModel = new DashboardViewModel($data);

        return view('admin.admin-dashboard', $viewModel->toArray());
    }
}
