<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use App\Models\DealDate;
use App\Models\Property;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DealsController extends Controller
{
    public function index()
    {
        $partner = Auth::user()->partner;
        if (!$partner) {
            return redirect()->route('partner.dashboard')->with('error', 'Partner profile not found.');
        }

        $deals = Deal::where('partner_id', $partner->id)
            ->with('property')
            ->latest()
            ->paginate(10);

        return view('partner.deals.index', compact('deals'));
    }

    public function create()
    {
        $properties = Property::where('user_id', Auth::id())
            ->with(['pricing', 'rooms'])
            ->get()
            ->map(function ($property) {
                // Calculate total price with commission for display
                $commissionRate = $property->commission_rate ?? 0;
                $adultPriceBase = $property->adult_price ?? 0;
                $childPriceBase = $property->child_price ?? 0;

                $adultPriceWithComm = $adultPriceBase + ($adultPriceBase * $commissionRate / 100);
                $childPriceWithComm = $childPriceBase + ($childPriceBase * $commissionRate / 100);

                $property->adult_price_display = $adultPriceWithComm;
                $property->child_price_display = $childPriceWithComm;
                $property->price_per_night_display = $property->pricing->price_per_night ?? 0;

                return $property;
            });

        $rooms = Room::whereHas('property', function ($q) {
            $q->where('user_id', Auth::id());
        })->with('property')->get();

        return view('partner.deals.create', compact('properties', 'rooms'));
    }

    public function store(Request $request)
    {
        $partner = Auth::user()->partner;
        if (!$partner) {
            return redirect()->route('partner.dashboard')->with('error', 'Partner profile not found.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deal_type' => 'required|in:percentage,fixed,special',
            'discount_percentage' => 'required_if:deal_type,percentage|nullable|integer|min:1|max:90',
            'fixed_discount_amount' => 'required_if:deal_type,fixed|nullable|numeric|min:0',
            'special_offer_text' => 'required_if:deal_type,special|nullable|string|max:255',
            'discounted_price' => 'required_if:deal_type,special|nullable|numeric|min:0',
            'applicable_to' => 'required|in:property,room',
            'property_id' => 'required|exists:properties,id',
            'room_id' => 'required_if:applicable_to,room|nullable|exists:rooms,id',
            'original_price' => 'required|numeric|min:0',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'available_dates' => 'nullable|array',
            'available_dates.*' => 'date'
        ]);

        // Additional validation: Ensure mutual exclusivity of deal type fields
        if ($request->deal_type === 'percentage' && ($request->fixed_discount_amount || $request->discounted_price)) {
            return back()->withErrors(['deal_type' => 'Percentage deals cannot have fixed discount or discounted price.']);
        }
        if ($request->deal_type === 'fixed' && ($request->discount_percentage || $request->discounted_price)) {
            return back()->withErrors(['deal_type' => 'Fixed discount deals cannot have percentage or discounted price.']);
        }
        if ($request->deal_type === 'special' && ($request->discount_percentage || $request->fixed_discount_amount)) {
            return back()->withErrors(['deal_type' => 'Special deals cannot have percentage or fixed discount.']);
        }

        $discountedPrice = $this->calculateDiscountedPrice($request);

        // Get property currency
        $property = Property::find($request->property_id);
        $currency = $property ? ($property->currency ?? 'USD') : 'USD';

        $deal = Deal::create([
            'title' => $request->title,
            'description' => $request->description,
            'deal_type' => $request->deal_type,
            'discount_percentage' => $request->deal_type === 'percentage' ? $request->discount_percentage : null,
            'fixed_discount_amount' => $request->deal_type === 'fixed' ? $request->fixed_discount_amount : null,
            'special_offer_text' => $request->deal_type === 'special' ? $request->special_offer_text : null,
            'applicable_to' => $request->applicable_to,
            'original_price' => $request->original_price,
            'discounted_price' => $discountedPrice,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'property_id' => $request->property_id,
            'room_id' => $request->applicable_to === 'room' ? $request->room_id : null,
            'partner_id' => $partner->id,
            'status' => 'active',
            'currency' => $currency
        ]);

        if ($request->available_dates) {
            foreach ($request->available_dates as $date) {
                $carbonDate = Carbon::parse($date);
                DealDate::create([
                    'deal_id' => $deal->id,
                    'available_date' => $date,
                    'is_weekend' => $carbonDate->isWeekend()
                ]);
            }
        }

        return redirect()->route('partner.deals.index')->with('success', 'Deal created successfully!');
    }

    public function edit(Deal $deal)
    {
        $properties = Property::where('user_id', Auth::id())
            ->with(['pricing', 'rooms'])
            ->get();
        $rooms = Room::whereHas('property', function ($q) {
            $q->where('user_id', Auth::id());
        })->with('property')->get();

        $deal->load('dealDates');

        return view('partner.deals.edit', compact('deal', 'properties', 'rooms'));
    }

    public function update(Request $request, Deal $deal)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deal_type' => 'required|in:percentage,fixed,special',
            'discount_percentage' => 'required_if:deal_type,percentage|nullable|integer|min:1|max:90',
            'fixed_discount_amount' => 'required_if:deal_type,fixed|nullable|numeric|min:0',
            'special_offer_text' => 'required_if:deal_type,special|nullable|string|max:255',
            'discounted_price' => 'required_if:deal_type,special|nullable|numeric|min:0',
            'applicable_to' => 'required|in:property,room',
            'property_id' => 'required|exists:properties,id',
            'room_id' => 'required_if:applicable_to,room|nullable|exists:rooms,id',
            'original_price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'available_dates' => 'nullable|array',
            'available_dates.*' => 'date'
        ]);

        // Additional validation: Ensure mutual exclusivity of deal type fields
        if ($request->deal_type === 'percentage' && ($request->fixed_discount_amount || $request->discounted_price)) {
            return back()->withErrors(['deal_type' => 'Percentage deals cannot have fixed discount or discounted price.']);
        }
        if ($request->deal_type === 'fixed' && ($request->discount_percentage || $request->discounted_price)) {
            return back()->withErrors(['deal_type' => 'Fixed discount deals cannot have percentage or discounted price.']);
        }
        if ($request->deal_type === 'special' && ($request->discount_percentage || $request->fixed_discount_amount)) {
            return back()->withErrors(['deal_type' => 'Special deals cannot have percentage or fixed discount.']);
        }

        $discountedPrice = $this->calculateDiscountedPrice($request);

        $deal->update([
            'title' => $request->title,
            'description' => $request->description,
            'deal_type' => $request->deal_type,
            'discount_percentage' => $request->deal_type === 'percentage' ? $request->discount_percentage : null,
            'fixed_discount_amount' => $request->deal_type === 'fixed' ? $request->fixed_discount_amount : null,
            'special_offer_text' => $request->deal_type === 'special' ? $request->special_offer_text : null,
            'applicable_to' => $request->applicable_to,
            'original_price' => $request->original_price,
            'discounted_price' => $discountedPrice,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'property_id' => $request->property_id,
            'room_id' => $request->applicable_to === 'room' ? $request->room_id : null
        ]);

        // Update deal dates
        $deal->dealDates()->delete();
        if ($request->available_dates) {
            foreach ($request->available_dates as $date) {
                $carbonDate = Carbon::parse($date);
                DealDate::create([
                    'deal_id' => $deal->id,
                    'available_date' => $date,
                    'is_weekend' => $carbonDate->isWeekend()
                ]);
            }
        }

        return redirect()->route('partner.deals.index')->with('success', 'Deal updated successfully!');
    }

    public function destroy(Deal $deal)
    {
        $deal->delete();
        return redirect()->route('partner.deals.index')->with('success', 'Deal deleted successfully!');
    }

    public function toggleStatus(Deal $deal)
    {
        $deal->update(['status' => $deal->status === 'active' ? 'inactive' : 'active']);
        return back()->with('success', 'Deal status updated successfully!');
    }

    private function calculateDiscountedPrice($request)
    {
        switch ($request->deal_type) {
            case 'percentage':
                return $request->original_price * (1 - $request->discount_percentage / 100);
            case 'fixed':
                return max(0, $request->original_price - $request->fixed_discount_amount);
            case 'special':
                // Fix: Use discounted_price from request instead of hardcoded 20%
                return $request->discounted_price ?? $request->original_price;
            default:
                return $request->original_price;
        }
    }
}
