<?php

namespace App\Actions\Partner;

use App\Services\Partner\DashboardService;

class GetDashboardDataAction
{
    public function __construct(
        private DashboardService $dashboardService
    ) {}

    public function execute(): array
    {
        return [
            'stats' => $this->dashboardService->getDashboardStats(),
            'recentBookings' => $this->dashboardService->getRecentBookings(),
            'chartData' => $this->dashboardService->getChartData(),
            'recentActivity' => $this->dashboardService->getRecentActivity()
        ];
    }
}