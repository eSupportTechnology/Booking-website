<?php

namespace App\Services\Admin;

use App\Models\Taxi;
use App\DTOs\Admin\TaxiListDTO;
use Illuminate\Pagination\LengthAwarePaginator;

class TaxiService
{
    public function getTaxiList(TaxiListDTO $dto): LengthAwarePaginator
    {
        $query = Taxi::with(['type', 'drivers', 'renter']);

        if ($dto->search) {
            $query->where(function ($q) use ($dto) {
                $q->where('number_plate', 'like', "%{$dto->search}%")
                  ->orWhereHas('drivers', function ($driverQuery) use ($dto) {
                      $driverQuery->where('name', 'like', "%{$dto->search}%");
                  })
                  ->orWhereHas('type', function ($typeQuery) use ($dto) {
                      $typeQuery->where('name', 'like', "%{$dto->search}%");
                  });
            });
        }

        if ($dto->status) {
            $query->where('status', $dto->status);
        }

        // Show all taxis regardless of approval status for admin review
        return $query->orderBy('approval_status', 'asc')
                    ->orderBy('created_at', 'desc')
                    ->paginate($dto->perPage);
    }

    public function getTaxiById(int $id): ?Taxi
    {
        return Taxi::with(['type', 'drivers', 'renter', 'fare'])->find($id);
    }
}