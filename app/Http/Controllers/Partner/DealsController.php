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
                             ->get();
        $rooms = Room::whereHas('property', function($q) {
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
            'discount_percentage' => 'required_if:deal_type,percentage|integer|min:1|max:90',
            'fixed_discount_amount' => 'required_if:deal_type,fixed|numeric|min:0',
            'special_offer_text' => 'required_if:deal_type,special|string|max:255',
            'applicable_to' => 'required|in:property,room',
            'property_id' => 'required|exists:properties,id',
            'room_id' => 'required_if:applicable_to,room|exists:rooms,id',
            'original_price' => 'required|numeric|min:0',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'available_dates' => 'nullable|array',
            'available_dates.*' => 'date'
        ]);

        $discountedPrice = $this->calculateDiscountedPrice($request);

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
            'status' => 'active'
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
        $rooms = Room::whereHas('property', function($q) {
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
            'discount_percentage' => 'required_if:deal_type,percentage|integer|min:1|max:90',
            'fixed_discount_amount' => 'required_if:deal_type,fixed|numeric|min:0',
            'special_offer_text' => 'required_if:deal_type,special|string|max:255',
            'applicable_to' => 'required|in:property,room',
            'property_id' => 'required|exists:properties,id',
            'room_id' => 'required_if:applicable_to,room|exists:rooms,id',
            'original_price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'available_dates' => 'nullable|array',
            'available_dates.*' => 'date'
        ]);

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
                return $request->original_price * 0.8; // Default 20% off for special offers
            default:
                return $request->original_price;
        }
    }
}