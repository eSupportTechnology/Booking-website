<?php

namespace App\DTOs\Partner;

use Illuminate\Http\Request;

class StoreRatePlansDTO
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
        ]);

        return new self($validated);
    }
}
