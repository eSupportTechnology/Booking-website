<?php
namespace App\DTOs\Partner;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class SaveRoomsDTO extends ValidatedDTO
{
    public int $property_id;
    public array $rooms;

    public function rules(): array
    {
        return [
            'property_id' => ['required', 'exists:properties,id'],
            'rooms' => ['required', 'array', 'min:1'],
            'rooms.*.room_type_id' => ['required', 'exists:room_types,id'],
            'rooms.*.name' => ['nullable', 'string'],
            'rooms.*.price_per_night' => ['nullable', 'numeric'],
            'rooms.*.max_guests' => ['nullable', 'integer'],
            'rooms.*.bathroom_count' => ['nullable', 'integer'],
            'rooms.*.size_sq_m' => ['nullable', 'numeric'],
            'rooms.*.beds' => ['nullable', 'array'],
        ];
    }

    protected function casts(): array
    {
        return [
           
        ];
    }
    protected function defaults(): array
    {
        return [
            'rooms' => [],
        ];
    }
}
