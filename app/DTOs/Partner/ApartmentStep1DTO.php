<?php

namespace App\DTOs\Partner;

use WendellAdriel\ValidatedDTO\ValidatedDTO;
use WendellAdriel\ValidatedDTO\Casting\IntegerCast;

class ApartmentStep1DTO extends ValidatedDTO
{
    public int $category_id;
    public ?int $property_count;
    public ?int $address_type_id;
    public ?int $user_id;

    protected function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:property_categories,id'],
            'property_count' => ['nullable', 'integer', 'min:1'],
            'address_type_id' => ['nullable', 'integer'],
            'user_id' => ['nullable', 'integer'],
        ];
    }

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [
            'category_id' => new IntegerCast(),
            'property_count' => new IntegerCast(),
            'address_type_id' => new IntegerCast(),
            'user_id' => new IntegerCast(),
        ];
    }
} 