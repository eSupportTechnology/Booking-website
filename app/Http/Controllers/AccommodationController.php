<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accommodation;
use App\Models\Individual;
use App\Models\BusinessEntity;

class AccommodationController extends Controller
{
    public function saveVerification(Request $request, $propertyId, \App\Actions\Partner\StoreAccommodationDetailsAction $action)
    {
        // Use DTO for validation and mapping
        $dto = \App\DTOs\Partner\AccommodationDetailsDTO::fromRequest($request);

        // Set property_id from route if not present in request
        $dto->property_id = $propertyId;

        // Use the action to save all details
        $accommodation = $action->execute($dto);

        return response()->json([
            'success' => true,
            'message' => 'Accommodation verification saved.',
            'accommodation_id' => $accommodation->id,
        ]);
    }
}
