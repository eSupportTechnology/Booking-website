<?php

namespace App\Services\Admin;

use App\Models\Taxi;
use App\DTOs\Admin\AirportTransferListDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class AirportTransferService
{
    public function getTransferList(AirportTransferListDTO $dto): LengthAwarePaginator
    {
        // For now, we'll use taxi data as airport transfers
        // In a real scenario, you'd have a separate AirportTransfer model
        $query = Taxi::with(['type', 'drivers', 'renter']);

        if ($dto->search) {
            $query->where(function ($q) use ($dto) {
                $q->where('number_plate', 'like', "%{$dto->search}%")
                  ->orWhereHas('drivers', function ($driverQuery) use ($dto) {
                      $driverQuery->where('name', 'like', "%{$dto->search}%");
                  });
            });
        }

        if ($dto->status) {
            $query->where('status', $dto->status);
        }

        return $query->paginate($dto->perPage);
    }

    public function getTransferById(int $id): ?Taxi
    {
        return Taxi::with(['type', 'drivers', 'renter', 'fare'])->find($id);
    }
}