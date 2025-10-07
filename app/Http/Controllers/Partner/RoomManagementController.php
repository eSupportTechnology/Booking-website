<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomManagementController extends Controller
{
    public function index(Property $property)
    {
        // Ensure the property belongs to the authenticated partner
        if ($property->user_id !== Auth::id()) {
            abort(403);
        }

        $rooms = $property->rooms()
            ->with(['roomType', 'amenities', 'beds', 'ratePlans'])
            ->get()
            ->map(function ($room) {
                return [
                    'id' => $room->id,
                    'name' => $room->name,
                    'description' => $room->description,
                    'room_type' => $room->roomType,
                    'room_type_id' => $room->room_type_id,
                    'max_guests' => $room->max_guests,
                    'size_sq_m' => $room->size_sq_m,
                    'bathroom_type' => $room->bathroom_type,
                    'bathroom_count' => $room->bathroom_count,
                    'smoking_allowed' => $room->smoking_allowed,
                    'price_per_night' => $room->price_per_night,
                    'currency' => $room->currency,
                    'is_available' => $this->checkRoomAvailability($room),
                    'amenities' => $room->amenities,
                    'beds' => $room->beds,
                    'rate_plans' => $room->ratePlans
                ];
            });

        return response()->json([
            'success' => true,
            'rooms' => $rooms
        ]);
    }

    public function getRoomTypes()
    {
        $roomTypes = RoomType::all();
        
        return response()->json([
            'success' => true,
            'room_types' => $roomTypes
        ]);
    }

    public function toggleAvailability(Room $room)
    {
        // Ensure the room belongs to a property owned by the authenticated partner
        if ($room->property->user_id !== Auth::id()) {
            abort(403);
        }

        // For simplicity, we'll toggle a hypothetical 'is_active' field
        // In a real implementation, you might want to create/update availability records
        $room->update([
            'is_active' => !($room->is_active ?? true)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Room availability updated successfully'
        ]);
    }

    public function destroy(Room $room)
    {
        // Ensure the room belongs to a property owned by the authenticated partner
        if ($room->property->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if room has any active bookings
        $hasActiveBookings = $room->bookings()
            ->whereIn('status', ['confirmed', 'pending'])
            ->where('check_out', '>=', now())
            ->exists();

        if ($hasActiveBookings) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete room with active bookings'
            ], 400);
        }

        $room->delete();

        return response()->json([
            'success' => true,
            'message' => 'Room deleted successfully'
        ]);
    }

    public function updatePricing(Request $request, Room $room)
    {
        // Ensure the room belongs to a property owned by the authenticated partner
        if ($room->property->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'price_per_night' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
            'discount_enabled' => 'boolean',
            'commission_percentage' => 'nullable|numeric|min:0|max:100'
        ]);

        $room->update([
            'price_per_night' => $request->price_per_night,
            'currency' => $request->currency,
            'discount_enabled' => $request->discount_enabled ?? false,
            'commission_percentage' => $request->commission_percentage
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Room pricing updated successfully',
            'room' => $room->fresh()
        ]);
    }

    public function bulkUpdatePricing(Request $request, Property $property)
    {
        // Ensure the property belongs to the authenticated partner
        if ($property->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'room_ids' => 'required|array',
            'room_ids.*' => 'exists:rooms,id',
            'price_per_night' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3'
        ]);

        $rooms = Room::whereIn('id', $request->room_ids)
            ->where('property_id', $property->id)
            ->get();

        foreach ($rooms as $room) {
            $room->update([
                'price_per_night' => $request->price_per_night,
                'currency' => $request->currency
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Bulk pricing update completed',
            'updated_count' => $rooms->count()
        ]);
    }

    public function getAvailabilityCalendar(Room $room, Request $request)
    {
        // Ensure the room belongs to a property owned by the authenticated partner
        if ($room->property->user_id !== Auth::id()) {
            abort(403);
        }

        $startDate = $request->get('start_date', now()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->addMonths(3)->format('Y-m-d'));

        // Get bookings for the room in the date range
        $bookings = $room->bookings()
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('check_in', [$startDate, $endDate])
                    ->orWhereBetween('check_out', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('check_in', '<=', $startDate)
                          ->where('check_out', '>=', $endDate);
                    });
            })
            ->get(['check_in', 'check_out', 'status']);

        // Get availability overrides
        $availabilityOverrides = $room->availability()
            ->whereBetween('date', [$startDate, $endDate])
            ->get(['date', 'is_available', 'price_override']);

        return response()->json([
            'success' => true,
            'bookings' => $bookings,
            'availability_overrides' => $availabilityOverrides,
            'base_price' => $room->price_per_night
        ]);
    }

    private function checkRoomAvailability(Room $room): bool
    {
        // Check if room has any bookings for today
        $today = now()->format('Y-m-d');
        
        return !$room->bookings()
            ->where('status', '!=', 'cancelled')
            ->where('check_in', '<=', $today)
            ->where('check_out', '>', $today)
            ->exists();
    }
}