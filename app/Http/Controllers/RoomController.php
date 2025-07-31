<?php

namespace App\Http\Controllers;

use App\Models\BedType;
use App\Models\Room;
use App\Models\RoomBed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    public function store(Request $request)
    {
        try {
            Log::info('Received room creation request:', $request->all());
            $saved_rooms = [];
            $validated = $request->validate([
                'property_id' => 'required|exists:properties,id',
                'room_type' => 'nullable|string|max:255',
                'max_guests' => 'required|integer|min:1',
                'smoking_allowed' => 'boolean',
                'size_sq_m' => 'nullable|numeric|min:0',
                'beds' => 'nullable|array',
                'beds.*.label' => 'required|string',
                'beds.*.count' => 'required|integer|min:1',
                'room_count' => 'required|integer|min:1',
            ]);

            for ($i = 0; $i < $validated['room_count']; $i++) {
                // 🌟 Step 1: Create Room                
                $room = Room::create([
                    'property_id' => $validated['property_id'],
                    'room_type' => $validated['room_type'] ?? null,
                    'room_type_id' => $validated['room_type'] ?? null,
                    'max_guests' => $validated['max_guests'],
                    'smoking_allowed' => $validated['smoking_allowed'],
                    'size_sq_m' => $validated['size_sq_m'],
                    'name' => 'Default Room', // You can customize this
                    'price_per_night' => 0.00, // default placeholder
                    'bed_count' => 1,
                    'bathroom_count' => 1,
                    'bathroom_type' => null,
                    'currency' => 'usd',
                    'discount_enabled' => false,
                    'commission_percentage' => 15.00,
                    'you_earn' => 0.00
                ]);

                $saved_rooms[$i] = $room->id;

                // 🌟 Step 2: Save Beds
                $totalBeds = 0;

                foreach ($validated['beds'] ?? [] as $bed) {
                    $bedType = BedType::where('name', $bed['label'])->first();

                    if ($bedType) {
                        RoomBed::create([
                            'room_id' => $room->id,
                            'bed_type_id' => $bedType->id,
                            'count' => $bed['count']
                        ]);

                        $totalBeds += $bed['count'];
                    }
                }
            }



            Log::info('Rooms created:', $saved_rooms);
            // Update bed_count in room
            $room->update(['bed_count' => $totalBeds]);

            return response()->json(['success' => true, 'saved_rooms' => $saved_rooms]);
        } catch (\Exception $e) {
            Log::info('Error creating room', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateBathroomDetails(Request $request)
    {
        try {
            Log::info('Updating bathroom details', $request->all());
            $validated = $request->validate([
                'rooms' => 'required|array',
                'rooms.*.id' => 'required|exists:rooms,id',
                'rooms.*.bathroom_type' => 'required|in:private,shared',
                'rooms.*.bathroom_amenities' => 'nullable|array',
                'rooms.*.bathroom_amenities.*' => 'string|max:255',
            ]);

            foreach ($validated['rooms'] as $roomData) {
                $room = Room::find($roomData['id']);
                $room->update([
                    'bathroom_type' => $roomData['bathroom_type'],
                    'bathroom_amenities' => $roomData['bathroom_amenities'] ?? [],
                ]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error updating bathroom details', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function saveStep3Amenities(Request $request)
    {
        try {
            Log::info('Saving amenities', $request->all());
            $validated = $request->validate([
                'rooms' => 'required|array',
                'amenities' => 'required|array',
            ]);

            foreach ($validated['rooms'] as $roomId) {
                $room = Room::find($roomId);
                $room->amenities()->sync($validated['amenities']);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function saveStep4RoomName(Request $request)
    {
        Log::info('Saving room names', $request->all());
        $validated = $request->validate([
            'rooms' => 'required|array',
            'rooms.*.id' => 'required|exists:rooms,id',
            'rooms.*.name' => 'required|string|max:255',
        ]);

        foreach ($validated['rooms'] as $roomData) {
            $room = Room::findOrFail($roomData['id']);
            $room->name = $roomData['name'];
            $room->save();
        }

        return response()->json(['success' => true]);
    }

    public function saveStep5RoomPrices(Request $request)
    {
        $validated = $request->validate([
            'rooms' => 'required|array',
            'rooms.*.id' => 'required|exists:rooms,id',
            'rooms.*.price_per_night' => 'required|numeric',
        ]);

        foreach ($validated['rooms'] as $roomData) {
            $room = Room::findOrFail($roomData['id']);
            $room->price_per_night = $roomData['price_per_night'];
            $room->save();
        }

        return response()->json(['success' => true]);
    }
}
