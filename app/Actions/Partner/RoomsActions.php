<?php

namespace App\Actions\Partner;

use App\DTOs\Partner\StoreRoomDTO ;
use App\Models\Room;
use App\Models\RoomBed;
use App\Models\BedType;
use Illuminate\Support\Facades\DB;

class RoomsActions
{
    public function execute(StoreRoomDTO $dto): array
    {
        $saved_rooms = [];

        DB::beginTransaction();

        try {
            for ($i = 0; $i < $dto->room_count; $i++) {
                // Create Room
                $room = Room::create([
                    'property_id' => $dto->property_id,
                    'room_type' => $dto->room_type,
                    'room_type_id' => $dto->room_type, // Adjust if this is separate from room_type
                    'max_guests' => $dto->max_guests,
                    'smoking_allowed' => $dto->smoking_allowed,
                    'size_sq_m' => $dto->size_sq_m,
                    'name' => 'Default Room',
                    'price_per_night' => 0.00,
                    'bed_count' => 1, // will be updated below
                    'bathroom_count' => 1,
                    'bathroom_type' => null,
                    'currency' => 'usd',
                    'discount_enabled' => false,
                    'commission_percentage' => 15.00,
                    'you_earn' => 0.00,
                ]);

                $saved_rooms[] = $room->id;

                // Save Beds
                $totalBeds = 0;

                foreach ($dto->beds as $bed) {
                    $bedType = BedType::where('name', $bed['label'])->first();

                    if ($bedType) {
                        RoomBed::create([
                            'room_id' => $room->id,
                            'bed_type_id' => $bedType->id,
                            'count' => $bed['count'],
                        ]);

                        $totalBeds += $bed['count'];
                    }
                }

                $room->update(['bed_count' => $totalBeds]);
            }

            DB::commit();

            return $saved_rooms;

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
