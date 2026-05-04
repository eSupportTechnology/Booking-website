<?php
namespace App\DTOs\Partner;

use WendellAdriel\ValidatedDTO\ValidatedDTO;


class SaveAmenitiesDTO extends ValidatedDTO
{
    /** @var int[] */
    public array $amenities;

    /**
     * Validation rules for the SaveAmenitiesDTO
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'amenities' => ['nullable', 'array'],
            'amenities.*' => ['exists:amenities,id'],
        ];
    }

    protected function casts(): array
    {
        return [
        ];
    }

    /**
     * Default values for the SaveAmenitiesDTO
     *
     * @return array
     */
    protected function defaults(): array
    {
        return [
            'amenities' => [],
        ];
    }
}
