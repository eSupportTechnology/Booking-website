<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\SeasonalPricing;
use Illuminate\Http\Request;

class SeasonalPricingController extends Controller
{
    public function index($propertyId)
    {
        $property = Property::where('id', $propertyId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $seasonalPricings = SeasonalPricing::where('property_id', $propertyId)
            ->orderBy('start_date')
            ->get();

        return view('partner.seasonal-pricing.index', compact('property', 'seasonalPricings'));
    }

    public function store(Request $request, $propertyId)
    {
        $property = Property::where('id', $propertyId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $request->validate([
            'season_name' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'adult_price' => 'required|numeric|min:0',
            'child_price' => 'nullable|numeric|min:0',
            'commission_rate' => 'required|numeric|min:0|max:100',
        ]);

        $adultPrice = $request->adult_price;
        $childPrice = $request->child_price ?? 0;
        $commissionRate = $request->commission_rate;
        
        $basePrice = $adultPrice + $childPrice;
        $totalPrice = $basePrice + ($basePrice * $commissionRate / 100);

        SeasonalPricing::create([
            'property_id' => $propertyId,
            'season_name' => $request->season_name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'adult_price' => $adultPrice,
            'child_price' => $childPrice,
            'commission_rate' => $commissionRate,
            'total_price_with_commission' => $totalPrice,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Seasonal pricing created successfully'
        ]);
    }

    public function update(Request $request, $propertyId, $seasonalPricingId)
    {
        $property = Property::where('id', $propertyId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $seasonalPricing = SeasonalPricing::where('id', $seasonalPricingId)
            ->where('property_id', $propertyId)
            ->firstOrFail();

        $request->validate([
            'season_name' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'adult_price' => 'required|numeric|min:0',
            'child_price' => 'nullable|numeric|min:0',
            'commission_rate' => 'required|numeric|min:0|max:100',
        ]);

        $adultPrice = $request->adult_price;
        $childPrice = $request->child_price ?? 0;
        $commissionRate = $request->commission_rate;
        
        $basePrice = $adultPrice + $childPrice;
        $totalPrice = $basePrice + ($basePrice * $commissionRate / 100);

        $seasonalPricing->update([
            'season_name' => $request->season_name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'adult_price' => $adultPrice,
            'child_price' => $childPrice,
            'commission_rate' => $commissionRate,
            'total_price_with_commission' => $totalPrice,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Seasonal pricing updated successfully'
        ]);
    }

    public function destroy($propertyId, $seasonalPricingId)
    {
        $property = Property::where('id', $propertyId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        SeasonalPricing::where('id', $seasonalPricingId)
            ->where('property_id', $propertyId)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Seasonal pricing deleted successfully'
        ]);
    }

    public function getPriceForDate(Request $request, $propertyId)
    {
        $property = Property::where('id', $propertyId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $date = $request->input('date');
        
        $seasonalPricing = SeasonalPricing::where('property_id', $propertyId)
            ->active()
            ->forDate($date)
            ->first();

        if ($seasonalPricing) {
            return response()->json([
                'adult_price' => $seasonalPricing->adult_price,
                'child_price' => $seasonalPricing->child_price,
                'commission_rate' => $seasonalPricing->commission_rate,
                'total_price' => $seasonalPricing->total_price_with_commission,
                'season_name' => $seasonalPricing->season_name,
            ]);
        }

        // Return default pricing
        return response()->json([
            'adult_price' => $property->adult_price,
            'child_price' => $property->child_price,
            'commission_rate' => $property->commission_rate,
            'total_price' => $property->total_price_with_commission,
            'season_name' => 'Default',
        ]);
    }
}