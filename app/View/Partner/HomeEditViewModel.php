<?php

namespace App\View\Partner;

use App\Models\Property;

class HomeEditViewModel
{
    public function __construct(
        private Property $property,
        private array $rooms,
        private array $groupedAmenities,
        private array $allLanguages
    ) {}

    public function getProperty(): Property
    {
        return $this->property;
    }

    public function getRooms(): array
    {
        return $this->rooms;
    }

    public function getGroupedAmenities(): array
    {
        return $this->groupedAmenities;
    }

    public function getAllLanguages(): array
    {
        return $this->allLanguages;
    }

    public function getCompletionPercentage(): int
    {
        $completedSections = 0;
        $totalSections = 10;

        if ($this->property->title && $this->property->address) $completedSections++;
        if ($this->rooms) $completedSections++;
        if ($this->property->photos->count() >= 3) $completedSections++;
        if ($this->property->amenities->count() > 0) $completedSections++;
        if ($this->property->services) $completedSections++;
        if ($this->property->languages->count() > 0) $completedSections++;
        if ($this->property->policies) $completedSections++;
        if ($this->property->hostProfile) $completedSections++;
        if ($this->property->payment_method) $completedSections++;
        if ($this->property->partnerVerification) $completedSections++;

        return (int) (($completedSections / $totalSections) * 100);
    }

    public function isComplete(): bool
    {
        return $this->getCompletionPercentage() === 100;
    }
}