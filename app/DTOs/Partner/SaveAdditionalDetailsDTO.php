<?php

namespace App\DTOs\Partner;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class SaveAdditionalDetailsDTO extends ValidatedDTO
{
    public int $property_id;
    public ?array $languages;

    protected function rules(): array
    {
        return [
            'property_id' => ['required', 'exists:properties,id'],
            'languages' => ['nullable', 'array'],
            'languages.*' => ['exists:languages,id'],
        ];
    }

    protected function defaults(): array
    {
        return [
            'languages' => null,
        ];
    }

    protected function casts(): array
    {
        return [
            'property_id' => 'integer',
        ];
    }
} 