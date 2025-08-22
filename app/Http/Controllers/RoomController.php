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
}
