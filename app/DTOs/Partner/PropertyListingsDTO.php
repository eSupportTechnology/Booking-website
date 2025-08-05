<?php

namespace App\DTOs\Partner;

class PropertyListingsDTO
{
    public function __construct(
        public readonly int $apartments,
        public readonly int $homes,
        public readonly int $hotels,
        public readonly int $alternativePlaces
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            apartments: $data['apartments'] ?? 0,
            homes: $data['homes'] ?? 0,
            hotels: $data['hotels'] ?? 0,
            alternativePlaces: $data['alternative_places'] ?? 0
        );
    }

    public function getTotal(): int
    {
        return $this->apartments + $this->homes + $this->hotels + $this->alternativePlaces;
    }
}