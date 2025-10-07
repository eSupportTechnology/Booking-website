<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Room;
use App\Services\Customer\BookingService;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function __construct(private BookingService $bookingService) {}

    public function getAvailableRoomsWithDetails(Request $request, Property $property)
    {
        $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'integer|min:1|max:20'
        ]);

        $availableRooms = $this->bookingService->getAvailableRooms(
            $property, 
            $request->check_in, 
            $request->check_out
        );

        // Calculate nights for pricing
        $checkIn = new \DateTime($request->check_in);
        $checkOut = new \DateTime($request->check_out);
        $nights = $checkIn->diff($checkOut)->days;

        $roomsWithDetails = $availableRooms->map(function ($room) use ($nights, $request) {
            // Get current pricing (check for rate plans and overrides)
            $currentPrice = $this->getCurrentRoomPrice($room, $request->check_in, $request->check_out);
            
            return [
                'id' => $room->id,
                'name' => $room->name,
                'description' => $room->description,
                'room_type' => $room->roomType->name ?? 'Standard',
                'max_guests' => $room->max_guests,
                'size_sq_m' => $room->size_sq_m,
                'bathroom_type' => $room->bathroom_type,
                'bathroom_count' => $room->bathroom_count,
                'smoking_allowed' => $room->smoking_allowed,
                'price_per_night' => $currentPrice,
                'total_price' => $currentPrice * $nights,
                'currency' => $room->currency ?? 'LKR',
                'amenities' => $room->amenities->pluck('name')->toArray(),
                'beds' => $room->beds->map(function ($bed) {
                    return [
                        'type' => $bed->name,
                        'count' => $bed->pivot->count ?? 1
                    ];
                })->toArray(),
                'rate_plans' => $room->ratePlans->map(function ($plan) use ($nights) {
                    return [
                        'name' => $plan->name,
                        'price' => $plan->price,
                        'total_price' => $plan->price * $nights,
                        'discount' => $plan->discount,
                        'is_refundable' => $plan->is_refundable,
                        'min_nights' => $plan->min_nights,
                        'cancellation_days' => $plan->cancellation_days,
                        'policy_notes' => $plan->policy_notes
                    ];
                })->toArray()
            ];
        });

        return response()->json([
            'success' => true,
            'nights' => $nights,
            'rooms' => $roomsWithDetails
        ]);
    }

    private function getCurrentRoomPrice(Room $room, string $checkIn, string $checkOut): float
    {
        // Check for date-specific price overrides
        $availability = $room->availability()
            ->whereBetween('date', [$checkIn, $checkOut])
            ->whereNotNull('price_override')
            ->first();

        if ($availability && $availability->price_override) {
            return $availability->price_override;
        }

        // Return base room price
        return $room->price_per_night ?? 0;
    }

    public function getRoomDetails(Room $room)
    {
        $room->load(['roomType', 'amenities', 'beds', 'ratePlans']);
        
        return response()->json([
            'success' => true,
            'room' => [
                'id' => $room->id,
                'name' => $room->name,
                'description' => $room->description,
                'room_type' => $room->roomType->name ?? 'Standard',
                'max_guests' => $room->max_guests,
                'size_sq_m' => $room->size_sq_m,
                'bathroom_type' => $room->bathroom_type,
                'bathroom_count' => $room->bathroom_count,
                'bathroom_amenities' => $room->bathroom_amenities,
                'smoking_allowed' => $room->smoking_allowed,
                'price_per_night' => $room->price_per_night,
                'currency' => $room->currency ?? 'LKR',
                'amenities' => $room->amenities->map(function ($amenity) {
                    return [
                        'id' => $amenity->id,
                        'name' => $amenity->name,
                        'category' => $amenity->category
                    ];
                }),
                'beds' => $room->beds->map(function ($bed) {
                    return [
                        'type' => $bed->name,
                        'count' => $bed->pivot->count ?? 1
                    ];
                }),
                'rate_plans' => $room->ratePlans
            ]
        ]);
    }
}