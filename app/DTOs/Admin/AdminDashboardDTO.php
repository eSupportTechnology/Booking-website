<?php

namespace App\DTOs\Admin;

class AdminDashboardDTO
{
    public function __construct(
        public readonly int $totalProperties,
        public readonly int $totalPartners,
        public readonly int $totalCustomers,
        public readonly int $pendingApprovals,
        public readonly array $recentProperties,
        public readonly array $propertyStats
    ) {}
}
