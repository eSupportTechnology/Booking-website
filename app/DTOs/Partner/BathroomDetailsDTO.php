<?php

namespace App\DTOs\Partner;

use Illuminate\Http\Request;

class BathroomDetailsDTO
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
            'rooms.*.bathroom_type' => 'required|in:private,shared',
            'rooms.*.bathroom_amenities' => 'nullable|array',
            'rooms.*.bathroom_amenities.*' => 'string|max:255',
        ]);

        return new self($validated);
    }
}
