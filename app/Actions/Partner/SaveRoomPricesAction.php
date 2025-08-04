<?php

namespace App\Actions\Partner;

use App\DTOs\Partner\SaveRoomPricesDTO;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class SaveRoomPricesAction
{
    public function execute(SaveRoomPricesDTO $dto): void
    {
        DB::beginTransaction();

        try {
            foreach ($dto->rooms as $roomData) {
                $room = Room::findOrFail($roomData['id']);
                $room->price_per_night = $roomData['price_per_night'];
                $room->save();
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
