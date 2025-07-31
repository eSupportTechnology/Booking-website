<?php

namespace App\DTOs;

class SaveFacilitiesDTO
{
    public function __construct(
        public array $facilities
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            facilities: $data['facilities'] ?? []
        );
    }
} 