<?php

namespace App\DTOs\Admin;

class PropertyApprovalDTO
{
    public function __construct(
        public int $propertyId,
        public string $status,
        public ?string $rejectionReason = null
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            propertyId: $data['property_id'],
            status: $data['status'],
            rejectionReason: $data['rejection_reason'] ?? null
        );
    }
}
