<?php

namespace App\DTOs\Admin;

class AgingReportDTO
{
    public function __construct(
        public readonly string $dateFrom,
        public readonly string $dateTo,
        public readonly ?int $propertyType,
        public readonly ?string $status,
        public readonly array $agingData,
        public readonly array $propertyTypes,
        public readonly array $statuses
    ) {}
}