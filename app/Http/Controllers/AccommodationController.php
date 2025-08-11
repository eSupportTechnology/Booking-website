<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accommodation;
use App\Models\Individual;
use App\Models\BusinessEntity;

class AccommodationController extends Controller
{
    public function saveVerification(Request $request, $propertyId)
    {
        $data = $request->all();

        // Validate incoming data here if needed...

        // Save Accommodation
        $accommodation = Accommodation::updateOrCreate(
            ['property_id' => $propertyId],
            ['ownership_type' => $data['ownership_type'] ?? null]
        );

        // Clear old individuals & business entities if needed before re-inserting (optional)
        $accommodation->individuals()->delete();
        $accommodation->businessEntities()->delete();

        // Save Individuals
        if (!empty($data['owners']) && is_array($data['owners'])) {
            foreach ($data['owners'] as $owner) {
                Individual::create([
                    'accommodation_id' => $accommodation->id,
                    'first_name' => $owner['firstName'] ?? '',
                    'last_name' => $owner['lastName'] ?? '',
                    'date_of_birth' => $owner['dob'] ?? null,
                ]);
            }
        }

        // Save Business Entity (if ownership type implies it, for example)
        if (!empty($data['legal_company_name'])) {
            BusinessEntity::updateOrCreate(
                ['accommodation_id' => $accommodation->id],
                ['business_name' => $data['legal_company_name']]
            );
        }

        return response()->json(['success' => true, 'message' => 'Accommodation verification saved.']);
    }
}
