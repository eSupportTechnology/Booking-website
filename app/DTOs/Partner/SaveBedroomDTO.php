<?php

namespace App\DTOs\Partner;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class SaveBedroomDTO extends ValidatedDTO
{
    public string $room_name;
    public array $beds;
    public ?string $source;
    public ?string $step;

    protected function rules(): array
    {
        return [
            'room_name' => ['required', 'string'],
            'beds' => ['required', 'array'],
            'beds.*.id' => ['required', 'exists:bed_types,id'],
            'beds.*.count' => ['required', 'integer', 'min:0'],
            'source' => ['nullable', 'string', 'in:single,multiple'],
            'step' => ['nullable', 'string'],
        ];
    }

    protected function casts(): array
    {
        return [
            'beds.*.count' => 'integer',
        ];
    }

    protected function defaults(): array
    {
        return [
            'source' => null,
            'step' => null,
        ];
    }
} 