<?php

namespace App\DTOs\Partner;

class PropertyItemDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $type,
        public readonly string $location,
        public readonly string $status,
        public readonly int $bookings,
        public readonly string $image
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            type: $data['type'],
            location: $data['location'],
            status: $data['status'],
            bookings: $data['bookings'],
            image: $data['image']
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'location' => $this->location,
            'status' => $this->status,
            'bookings' => $this->bookings,
            'image' => $this->image
        ];
    }
}