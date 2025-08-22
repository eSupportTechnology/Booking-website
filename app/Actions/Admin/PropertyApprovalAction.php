<?php

namespace App\Actions\Admin;

use App\Models\Property;
use App\DTOs\Admin\PropertyApprovalDTO;
use App\Notifications\PropertyApprovalNotification;
use Illuminate\Support\Facades\DB;

class PropertyApprovalAction
{
    public function execute(PropertyApprovalDTO $dto): bool
    {
        return DB::transaction(function () use ($dto) {
            $property = Property::findOrFail($dto->propertyId);

            $property->status = $dto->status;
            $property->rejection_reason = $dto->rejectionReason;
            $property->reviewed_at = now();
            $property->reviewed_by = auth()->guard('admin')->id();
            $property->save();

            // Notify the partner
            $property->partner->notify(new PropertyApprovalNotification($property));

            return true;
        });
    }
}
