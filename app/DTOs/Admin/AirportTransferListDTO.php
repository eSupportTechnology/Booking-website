<?php

namespace App\DTOs\Admin;

class AirportTransferListDTO
{
    public function __construct(
        public string $search = '',
        public string $status = '',
        public int $perPage = 10
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            $request->get('search', '') ?? '',
            $request->get('status', '') ?? '',
            (int) $request->get('per_page', 10)
        );
    }

    public function toArray(): array
    {
        return [
            'search' => $this->search,
            'status' => $this->status,
            'per_page' => $this->perPage
        ];
    }
}