<?php

namespace App\Actions\Partner;

use App\DTOs\Partner\StoreRatePlansDTO;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class StoreRatePlansAction
{
    public function execute(StoreRatePlansDTO $dto): void
    {
        DB::beginTransaction();

        try {
            foreach ($dto->rooms as $roomData) {
                $room = Room::findOrFail($roomData['id']);

                $room->ratePlans()->delete();

                // Standard Rate
                $room->ratePlans()->create([
                    'name' => 'Standard Rate',
                    'price' => 30.00,
                    'discount' => 0,
                    'min_nights' => 1,
                    'is_refundable' => true,
                    'cancellation_days' => 1,
                    'policy_notes' => 'Free cancellation up to 1 day before arrival.',
                ]);

                // Non-refundable
                $room->ratePlans()->create([
                    'name' => 'Non-refundable Rate',
                    'price' => 27.00,
                    'discount' => 10,
                    'min_nights' => 1,
                    'is_refundable' => false,
                    'cancellation_days' => null,
                    'policy_notes' => 'Non-refundable rate with 10% discount.',
                ]);

                // Weekly
                $room->ratePlans()->create([
                    'name' => 'Weekly Rate',
                    'price' => 25.50,
                    'discount' => 15,
                    'min_nights' => 7,
                    'is_refundable' => true,
                    'cancellation_days' => 1,
                    'policy_notes' => '15% off for 7+ nights, refundable.',
                ]);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
