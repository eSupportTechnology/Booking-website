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




            // Update bed_count in room
            $room->update(['bed_count' => $totalBeds]);

            return response()->json(['success' => true, 'room_id' => $room->id]);
        } catch (\Exception $e) {
            Log::info('Error creating room', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
