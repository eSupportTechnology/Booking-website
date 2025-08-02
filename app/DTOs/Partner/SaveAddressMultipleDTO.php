<?php

namespace App\DTOs\Partner;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class SaveAddressMultipleDTO extends ValidatedDTO
{
    public int $first_property_id;
    public array $addresses;

    protected function rules(): array
    {
        return [
            'first_property_id' => ['required', 'exists:properties,id'],
            'addresses' => ['required', 'array'],
        ];
    }

    protected function casts(): array
    {
        return [
            'first_property_id' => 'integer',
        ];
    }
} 