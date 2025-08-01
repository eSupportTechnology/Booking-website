<?php

namespace App\DTOs\Partner;

use Illuminate\Http\Request;

class SaveRoomNamesDTO
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
            'rooms.*.name' => 'required|string|max:255',
        ]);

        return new self($validated);
    }
}
