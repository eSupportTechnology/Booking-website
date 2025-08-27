<?php

namespace App\DTOs\Admin;

use App\Models\User;

class CustomerListDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $phone,
        public readonly string $status,
        public readonly string $registrationDate,
        public readonly int $bookingsCount,
        public readonly int $reviewsCount
    ) {}

    public static function fromModel(User $user): self
    {
        $status = 'active';
        if (!$user->email_verified_at) {
            $status = 'pending';
        }

        return new self(
            id: $user->id,
            name: $user->name ?? 'N/A',
            email: $user->email,
            phone: $user->phone ?? null,
            status: $status,
            registrationDate: $user->created_at->format('Y-m-d'),
            bookingsCount: $user->bookings_count ?? 0,
            reviewsCount: $user->reviews_count ?? 0
        );
    }
}
