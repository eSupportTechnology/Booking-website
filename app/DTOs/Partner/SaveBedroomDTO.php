<?php

namespace App\DTOs\Partner;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class SaveBedroomDTO extends ValidatedDTO
{
    public string $room_name;
    public array $beds;

    protected function rules(): array
    {
        return [
            'room_name' => ['required', 'string'],
            'beds' => ['required', 'array'],
            'beds.*.id' => ['required', 'exists:bed_types,id'],
            'beds.*.count' => ['required', 'integer', 'min:0'],
        ];
    }

    protected function casts(): array
    {
        return [
            'beds.*.count' => 'integer',
        ];
    }
} 