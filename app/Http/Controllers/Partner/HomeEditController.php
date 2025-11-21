<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\AdminSettings;
use App\Actions\Partner\GetHomeEditDataAction;
use App\Services\Partner\HomeEditService;
use App\DTOs\Partner\HomeEditDTO;
use Illuminate\Http\Request;

class HomeEditController extends Controller
{
    public function __construct(
        private GetHomeEditDataAction $getHomeEditDataAction,
        private HomeEditService $homeEditService
    ) {}

    public function edit(Property $property)
    {
        $data = $this->getHomeEditDataAction->execute($property);

        return view('partner.homes.edit', $data);
    }

    public function updateBasicDetails(Request $request, Property $property)
    {
        $dto = HomeEditDTO::fromRequest($request->all());
        $this->homeEditService->updateBasicDetails($property, $dto);

        return response()->json(['success' => true, 'message' => 'Basic details updated successfully']);
    }

    public function updateAmenities(Request $request, Property $property)
    {
        $amenities = $request->input('amenities', []);
        $facilities = $request->input('facilities', []);

        // Filter out any non-numeric amenity IDs
        $amenities = array_filter($amenities, 'is_numeric');
        $amenities = array_map('intval', $amenities);

        $this->homeEditService->updateAmenities($property, [
            'amenities' => $amenities,
            'facilities' => array_filter($facilities)
        ]);

        return response()->json(['success' => true, 'message' => 'Amenities updated successfully']);
    }

    public function updatePhotos(Request $request, Property $property)
    {
        $request->validate([
            'photos.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120'
        ]);

        $this->homeEditService->updatePhotos($property, $request->file('photos', []), $request->main_photo);

        return response()->json(['success' => true, 'message' => 'Photos updated successfully']);
    }

    public function deletePhoto(Request $request, Property $property, $photoId)
    {
        $this->homeEditService->deletePhoto($property, $photoId);

        return response()->json(['success' => true, 'message' => 'Photo deleted successfully']);
    }

    public function updateServices(Request $request, Property $property)
    {
        $this->homeEditService->updateServices($property, $request->all());

        return response()->json(['success' => true, 'message' => 'Services updated successfully']);
    }

    public function updateLanguages(Request $request, Property $property)
    {
        $languages = array_merge($request->languages ?? [], $request->additional_languages ?? []);
        $this->homeEditService->updateLanguages($property, array_filter($languages));

        return response()->json(['success' => true, 'message' => 'Languages updated successfully']);
    }

    public function updateHouseRules(Request $request, Property $property)
    {
        $this->homeEditService->updateHouseRules($property, $request->all());

        return response()->json(['success' => true, 'message' => 'House rules updated successfully']);
    }

    public function updateHostProfile(Request $request, Property $property)
    {
        $this->homeEditService->updateHostProfile($property, $request->all());

        return response()->json(['success' => true, 'message' => 'Host profile updated successfully']);
    }

    public function updatePayments(Request $request, Property $property)
    {
        $this->homeEditService->updatePaymentSettings($property, $request->all());

        return response()->json(['success' => true, 'message' => 'Payment settings updated successfully']);
    }

    public function updateRooms(Request $request, Property $property)
    {
        $this->homeEditService->updateRooms($property, $request->all());

        return response()->json(['success' => true, 'message' => 'Rooms updated successfully']);
    }

    public function updateVerification(Request $request, Property $property)
    {
        $this->homeEditService->updateVerification($property, $request->all());

        return response()->json(['success' => true, 'message' => 'Verification details updated successfully']);
    }

    public function updatePricing(Request $request, Property $property)
    {
        $request->validate([
            'adult_price' => 'required|numeric|min:0',
            'child_price' => 'nullable|numeric|min:0',
            'currency' => 'required|string|in:USD,EUR,GBP,LKR'
        ]);

        $adultPrice = (float) $request->adult_price;
        $childPrice = (float) ($request->child_price ?? 0);

        // Always use admin's global commission rate (percentage)
        $commissionRate = AdminSettings::getGlobalCommissionRate();

        // Calculate commissions for adult and child prices
        $adultCommission = $adultPrice * ($commissionRate / 100);
        $childCommission = $childPrice * ($commissionRate / 100);
        $totalCommission = $adultCommission + $childCommission;
        $totalPriceWithCommission = $adultPrice + $adultCommission + $childPrice + $childCommission;

        // Update property with new pricing details
        $property->update([
            'adult_price' => $adultPrice,
            'child_price' => $childPrice,
            'commission_rate' => $commissionRate,
            'total_price_with_commission' => $totalPriceWithCommission,
            'currency' => $request->currency
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pricing settings updated successfully',
            'data' => [
                'adult_price' => $adultPrice,
                'child_price' => $childPrice,
                'commission_rate' => $commissionRate,
                'adult_commission' => $adultCommission,
                'child_commission' => $childCommission,
                'total_commission' => $totalCommission,
                'total_price_with_commission' => $totalPriceWithCommission,
                // Prices including commission for frontend display
                'adult_price_with_commission' => $adultPrice + $adultCommission,
                'child_price_with_commission' => $childPrice + $childCommission,
                'using_admin_default' => true
            ]
        ]);
    }
}
