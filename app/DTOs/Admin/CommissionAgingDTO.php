<?php

namespace App\DTOs\Admin;

class CommissionAgingDTO
{
    public function __construct(
        public readonly string $dateFrom,
        public readonly string $dateTo,
        public readonly ?int $partnerId,
        public readonly array $commissionData,
        public readonly array $partners,
        public readonly array $totals
    ) {}
}