<?php

namespace App\Actions\Partner;

use App\DTOs\Partner\SaveRoomAmenitiesDTO;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class SaveRoomAmenitiesAction
{
    public function execute(SaveRoomAmenitiesDTO $dto): void
    {
        DB::beginTransaction();

        try {
            foreach ($dto->rooms as $roomId) {
                $room = Room::find($roomId);

                if ($room) {
                    $room->amenities()->sync($dto->amenities);
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
