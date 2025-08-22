<?php

namespace App\DTOs\Partner;

class PropertyStatsDTO
{
    public function __construct(
        public readonly int $totalProperties,
        public readonly int $activeProperties,
        public readonly int $pendingApproval,
        public readonly int $inactiveProperties
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            totalProperties: $data['total_properties'] ?? 0,
            activeProperties: $data['active_properties'] ?? 0,
            pendingApproval: $data['pending_approval'] ?? 0,
            inactiveProperties: $data['inactive_properties'] ?? 0
        );
    }
}