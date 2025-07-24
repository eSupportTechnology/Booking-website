<?php
namespace App\DTOs\Partner;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class SaveAddressSameDTO extends ValidatedDTO
{
    public int $property_id;
    public int $count;
    public string $address;

    protected function rules(): array
    {
        return [
            'property_id' => ['required', 'exists:properties,id'],
            'count' => ['required', 'integer', 'min:1'],
            'address' => ['required', 'string', 'max:255'],
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
            'count' => 1,
        ];
    }
}