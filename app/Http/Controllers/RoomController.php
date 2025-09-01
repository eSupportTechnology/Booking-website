<?php

namespace App\Http\Controllers;

use App\Actions\Partner\BathroomDetailsAction;
use App\Actions\Partner\RoomsActions;
use App\Actions\Partner\SaveRoomAmenitiesAction;
use App\Actions\Partner\SaveRoomNamesAction;
use App\Actions\Partner\SaveRoomPricesAction;
use App\Actions\Partner\StoreRatePlansAction;
use App\DTOs\Partner\BathroomDetailsDTO;
use App\DTOs\Partner\SaveRoomAmenitiesDTO;
use App\DTOs\Partner\SaveRoomNamesDTO;
use App\DTOs\Partner\SaveRoomPricesDTO;
use App\DTOs\Partner\StoreRatePlansDTO;
use App\DTOs\Partner\StoreRoomDTO;
use App\Models\BedType;
use App\Models\Property;
use App\Models\Room;
use App\Models\RoomBed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    public function store(Request $request, RoomsActions $action)
    {
        try {
            Log::info('Received room creation request:', $request->all());

            $dto = StoreRoomDTO::fromRequest($request);
            $saved_rooms = $action->execute($dto);

            Log::info('Rooms created:', $saved_rooms);

            return response()->json(['success' => true, 'saved_rooms' => $saved_rooms]);
        } catch (\Exception $e) {
            Log::error('Error creating room', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateBathroomDetails(Request $request, BathroomDetailsAction $action)
    {
        try {
            Log::info('Updating bathroom details', $request->all());

            $dto = BathroomDetailsDTO::fromRequest($request);
            $action->execute($dto);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error updating bathroom details', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    public function saveStep3Amenities(Request $request, SaveRoomAmenitiesAction $action)
    {
        try {
            Log::info('Saving amenities', $request->all());

            $dto = SaveRoomAmenitiesDTO::fromRequest($request);
            $action->execute($dto);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error saving amenities', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function saveStep4RoomName(Request $request, SaveRoomNamesAction $action)
    {
        try {
            Log::info('Saving room names', $request->all());

            $dto = SaveRoomNamesDTO::fromRequest($request);
            $action->execute($dto);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error saving room names', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function saveStep5RoomPrices(Request $request, SaveRoomPricesAction $action)
    {
        try {
            $dto = SaveRoomPricesDTO::fromRequest($request);
            $action->execute($dto);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function updateBookingStatus(Request $request, $id)
    {
        $request->validate([
            'open_for_bookings' => 'required|boolean',
        ]);

        $property = Property::findOrFail($id);
        $property->open_for_bookings = $request->open_for_bookings;
        $property->save();

        return response()->json(['success' => true]);
    }


    public function storeRatePlans(Request $request, StoreRatePlansAction $action)
    {
        try {
            Log::info('storeRatePlans called', [
                'request' => $request->all(),
            ]);

            $dto = StoreRatePlansDTO::fromRequest($request);
            $action->execute($dto);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error saving rate plans', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroyByType($propertyId, $roomTypeId)
    {
        Room::where('property_id', $propertyId)
            ->where('room_type_id', $roomTypeId)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'All rooms of this type deleted successfully.'
        ]);
    }

    public function update(Request $request, $roomTypeId)
    {
        Log::info('Updating room details for room_type_id: ' . $roomTypeId, $request->all());
        $validated = $request->validate([
            'max_guests' => 'required|integer|min:1',
            'bed_count' => 'required|integer|min:1',
            'bathroom_type' => 'required|in:private,shared',
            'currency' => 'required|string|max:10',
            'price_per_night' => 'required|numeric|min:0',
            'room_count' => 'required|integer|min:1',
        ]);

        $currentRooms = Room::where('room_type_id', $roomTypeId)->where('property_id', $request->property_id)->orderBy('id', 'desc')->get();
        $currentCount = $currentRooms->count();
        $newCount = $validated['room_count'];

        $attributesToUpdate = [
            'max_guests' => $validated['max_guests'],
            'bed_count' => $validated['bed_count'],
            'bathroom_type' => $validated['bathroom_type'],
            'currency' => $validated['currency'],
            'price_per_night' => $validated['price_per_night'],
        ];

        Room::where('room_type_id', $roomTypeId)->where('property_id', $request->property_id)->update($attributesToUpdate);

        if ($newCount < $currentCount) {
            $roomsToDelete = $currentRooms->slice($newCount);
            foreach ($roomsToDelete as $room) {
                $room->delete();
            }
        } elseif ($newCount > $currentCount) {
            $roomTemplate = Room::where('property_id', $request->property_id)
                ->where('room_type_id', $roomTypeId)
                ->first();

            if ($roomTemplate) {
                for ($i = $currentCount; $i < $newCount; $i++) {
                    $newRoomData = $roomTemplate->toArray();
                    unset($newRoomData['id']); // remove primary key
                    $newRoomData['created_at'] = now();
                    $newRoomData['updated_at'] = now();

                    Room::create($newRoomData);
                }
            }
        }


        return response()->json(['message' => 'Room updated successfully'], 200);
    }
}
