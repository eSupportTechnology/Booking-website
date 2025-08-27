<?php

namespace App\DTOs\Admin;

class StatusUpdateDTO
{
    public function __construct(
        public readonly string $status,
        public readonly int $entityId,
        public readonly string $entityType
    ) {}

    public static function fromRequest(array $data, int $entityId, string $entityType): self
    {
        return new self(
            status: $data['status'],
            entityId: $entityId,
            entityType: $entityType
        );
    }

    public function isValidStatus(): bool
    {
        return in_array($this->status, ['active', 'inactive', 'pending']);
    }
}
