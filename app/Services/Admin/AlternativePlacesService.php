<?php

namespace App\Services\Admin;

use App\DTOs\Admin\PropertyListingDTO;
use App\Models\Property;

class AlternativePlacesService
{
    // app/Services/Admin/AlternativePlacesService.php

    public function getAlternativePlacesData(int $perPage = 15): array
    {
        $properties = Property::with(['user', 'photos', 'reviews', 'category'])
            ->whereHas('category', function ($query) {
                $query->where('name', 'Alternative places');
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->appends(['per_page' => $perPage]); // Preserve in pagination links

        return [
            'properties' => $properties->map(fn($property) => PropertyListingDTO::fromProperty($property)),
            'pagination' => $properties,
            'total' => $properties->total(),
            'perPage' => $perPage,
        ];
    }

    public function getPropertyStats(): array
    {
        return [
            'total' => Property::whereHas('category', fn($q) => $q->where('name', 'Alternative places'))->count(),
            'active' => Property::whereHas('category', fn($q) => $q->where('name', 'Alternative places'))->where('status', 'active')->count(),
            'pending' => Property::whereHas('category', fn($q) => $q->where('name', 'Alternative places'))->where('status', 'pending')->count(),
        ];
    }
}
