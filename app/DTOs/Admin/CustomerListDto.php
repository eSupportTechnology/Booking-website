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
        public readonly int $reviewsCount,
        public readonly ?string $address = null,
        public readonly ?string $nationality = null,
        public readonly ?string $dateOfBirth = null,
        public readonly ?string $gender = null,
        public readonly ?string $displayName = null
    ) {}

    public static function fromModel(User $user): self
    {
        $status = 'active';
        if (!$user->email_verified_at) {
            $status = 'pending';
        }

        $personalDetails = $user->customerPersonalDetail;

        // Format date of birth if it exists
        $dateOfBirth = $personalDetails && $personalDetails->date_of_birth
            ? date('Y-m-d', strtotime($personalDetails->date_of_birth))
            : null;

        return new self(
            id: $user->id,
            name: $user->name ?? 'N/A',
            email: $user->email,
            phone: $personalDetails?->phone_number ?? null,
            status: $status,
            registrationDate: $user->created_at->format('Y-m-d'),
            bookingsCount: $user->bookings_count ?? 0,
            reviewsCount: $user->reviews_count ?? 0,
            address: $personalDetails?->address ?? null,
            nationality: $personalDetails?->nationality ?? null,
            dateOfBirth: $dateOfBirth,
            gender: $personalDetails?->gender ?? null,
            displayName: $personalDetails?->display_name ?? null
        );
    }
}
