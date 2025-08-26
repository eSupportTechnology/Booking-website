<?php

namespace App\DTOs\Admin;

class PropertyListingDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $partnerName,
        public readonly string $location,
        public readonly string $status,
        public readonly string $createdAt,
        public readonly ?string $primaryImage = null,
        public readonly int $reviewsCount = 0,
        public readonly float $averageRating = 0.0,
        public readonly ?string $categoryName = null
    ) {}

    public static function fromProperty(\App\Models\Property $property): self
    {
        return new self(
            id: $property->id,
            title: $property->title ?? 'Untitled Property',
            partnerName: $property->user?->name ?? 'Unknown Partner',
            location: trim(($property->city ?? '') . ', ' . ($property->country ?? ''), ', ') ?: 'Unknown Location',
            status: $property->status ?? 'pending',
            createdAt: $property->created_at->format('M d Y'),
            primaryImage: $property->photos()->first()?->file_path,
            reviewsCount: $property->reviews()->count(),
            averageRating: $property->reviews()->avg('rating') ?? 0.0,
            categoryName: $property->category?->name
        );
    }
}
