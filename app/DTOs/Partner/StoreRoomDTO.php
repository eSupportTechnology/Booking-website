<?php

namespace App\DTOs\Partner;

use Illuminate\Http\Request;

class StoreRoomDTO
{
    public int $property_id;
    public ?string $room_type;
    public int $max_guests;
    public bool $smoking_allowed;
    public ?float $size_sq_m;
    public int $room_count;
    public array $beds;

    public function __construct(array $validated)
    {
        $this->property_id      = $validated['property_id'];
        $this->room_type        = $validated['room_type'] ?? null;
        $this->max_guests       = $validated['max_guests'];
        $this->smoking_allowed  = $validated['smoking_allowed'] ?? false;
        $this->size_sq_m        = $validated['size_sq_m'] ?? null;
        $this->room_count       = $validated['room_count'];
        $this->beds             = $validated['beds'] ?? [];
    }

    public static function fromRequest(Request $request): self
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'room_type' => 'nullable|string|max:255',
            'max_guests' => 'required|integer|min:1',
            'smoking_allowed' => 'boolean',
            'size_sq_m' => 'nullable|numeric|min:0',
            'beds' => 'nullable|array',
            'beds.*.label' => 'required|string',
            'beds.*.count' => 'required|integer|min:1',
            'room_count' => 'required|integer|min:1',
        ]);

        return new self($validated);
    }
}
