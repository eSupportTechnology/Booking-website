<?php

namespace App\DTOs\Partner;

use Illuminate\Http\Request;

class SaveRoomPricesDTO
{
    public array $rooms;

    public function __construct(array $validated)
    {
        $this->rooms = $validated['rooms'];
    }

    public static function fromRequest(Request $request): self
    {
        $validated = $request->validate([
            'rooms' => 'required|array',
            'rooms.*.id' => 'required|exists:rooms,id',
            'rooms.*.price_per_night' => 'required|numeric',
            'rooms.*.currency' => 'nullable|string|size:3',
        ]);

        return new self($validated);
    }
}
