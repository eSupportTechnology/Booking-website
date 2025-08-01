<?php

namespace App\Actions\Partner;

use App\DTOs\Partner\BathroomDetailsDTO;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class BathroomDetailsAction
{
    public function execute(BathroomDetailsDTO $dto): void
    {
        DB::beginTransaction();

        try {
            foreach ($dto->rooms as $roomData) {
                $room = Room::find($roomData['id']);
                $room->update([
                    'bathroom_type' => $roomData['bathroom_type'],
                    'bathroom_amenities' => $roomData['bathroom_amenities'] ?? [],
                ]);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
