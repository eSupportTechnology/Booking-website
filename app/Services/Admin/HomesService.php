<?php

namespace App\Services\Admin;

use App\DTOs\Admin\PropertyListingDTO;
use App\Models\Property;

class HomesService
{
    public function getHomesData(): array
    {
        $properties = Property::with(['user', 'photos', 'reviews', 'category'])
            ->whereHas('category', function ($query) {
                $query->where('name', 'Homes');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return [
            'properties' => $properties->map(fn($property) => PropertyListingDTO::fromProperty($property)),
            'pagination' => $properties->links(),
            'total' => $properties->total()
        ];
    }

    public function getPropertyStats(): array
    {
        return [
            'total' => Property::whereHas('category', fn($q) => $q->where('name', 'Homes'))->count(),
            'active' => Property::whereHas('category', fn($q) => $q->where('name', 'Homes'))->where('status', 'active')->count(),
            'pending' => Property::whereHas('category', fn($q) => $q->where('name', 'Homes'))->where('status', 'pending')->count(),
        ];
    }
}
