<?php

namespace App\Actions\Partner;

use App\Services\Partner\EarningsService;

class GetEarningsDataAction
{
    public function __construct(
        private EarningsService $earningsService
    ) {}

    public function execute(): array
    {
        return [
            'totalEarnings' => $this->earningsService->getTotalEarnings(),
            'monthlyEarnings' => $this->earningsService->getMonthlyEarnings(),
            'pendingPayout' => $this->earningsService->getPendingPayout(),
            'averageBooking' => $this->earningsService->getAverageBooking(),
            'transactions' => $this->earningsService->getTransactions()
        ];
    }
}