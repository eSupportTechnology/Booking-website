<?php


namespace App\Actions\Partner;

use App\DTOs\Partner\SaveRoomNamesDTO; 
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class SaveRoomNamesAction
{
    public function execute(SaveRoomNamesDTO $dto): void
    {
        DB::beginTransaction();

        try {
            foreach ($dto->rooms as $roomData) {
                $room = Room::findOrFail($roomData['id']);
                $room->name = $roomData['name'];
                $room->save();
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
