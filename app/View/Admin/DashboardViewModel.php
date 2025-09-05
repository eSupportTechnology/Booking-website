<?php

namespace App\View\Admin;

readonly class DashboardViewModel
{
    public int $totalCustomers;
    public int $totalPartners;
    public int $totalBookings;
    public float $revenue;
    public int $pendingVerifications;
    public array $recentBookings;
    public array $monthlyStats;
    public array $propertyTypes;

    public function __construct(array $data)
    {
        $this->totalCustomers = $data['totalCustomers'];
        $this->totalPartners = $data['totalPartners'];
        $this->totalBookings = $data['totalBookings'];
        $this->revenue = $data['revenue'];
        $this->pendingVerifications = $data['pendingVerifications'];
        $this->recentBookings = $data['recentBookings'];
        $this->monthlyStats = $data['monthlyStats'];
        $this->propertyTypes = $data['propertyTypes'];
    }

    public function toArray(): array
    {
        return [
            'totalCustomers' => $this->totalCustomers,
            'totalPartners' => $this->totalPartners,
            'totalBookings' => $this->totalBookings,
            'revenue' => number_format($this->revenue, 2),
            'pendingVerifications' => $this->pendingVerifications,
            'recentBookings' => $this->recentBookings,
            'monthlyStats' => $this->monthlyStats,
            'propertyTypes' => $this->propertyTypes,
        ];
    }

    public function getFormattedRevenue(): string
    {
        return '$' . number_format($this->revenue, 2);
    }

    public function getRecentBookingsCount(): int
    {
        return count($this->recentBookings);
    }
}
