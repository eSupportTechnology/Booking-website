<?php

namespace App\DTOs\Partner;

use Illuminate\Http\Request;

class SaveRoomAmenitiesDTO
{
    public array $rooms;
    public array $amenities;

    public function __construct(array $validated)
    {
        $this->rooms     = $validated['rooms'];
        $this->amenities = $validated['amenities'];
    }

    public static function fromRequest(Request $request): self
    {
        $validated = $request->validate([
            'rooms'     => 'required|array',
            'rooms.*'   => 'required|integer|exists:rooms,id',
            'amenities' => 'required|array',
            'amenities.*' => 'required|integer|exists:amenities,id',
        ]);

        return new self($validated);
    }
}
