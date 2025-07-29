<?php

namespace App\DTOs\Partner;

use Illuminate\Http\Request;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class PropertyServiceDTO extends ValidatedDTO
{
    public $property_id;
    public $serve_breakfast;
    public $breakfast_included;
    public $breakfast_type;
    public $parking_available;
    public $parking_cost;
    public $parking_cost_unit;
    public $parking_reservation;
    public $parking_location;
    public $parking_type;

    public function rules(): array
    {
        return [
            'property_id' => ['required', 'integer'],
            'serve_breakfast' => ['boolean'],
            'breakfast_included' => ['boolean'],
            'breakfast_type' => ['nullable', 'string'],
            'parking_available' => ['boolean'],
            'parking_cost' => ['nullable', 'numeric'],
            'parking_cost_unit' => ['nullable', 'string'],
            'parking_reservation' => ['boolean'],
            'parking_location' => ['nullable', 'string'],
            'parking_type' => ['nullable', 'string'],
        ];
    }

    public function defaults(): array
    {
        return [
            'serve_breakfast' => false,
            'breakfast_included' => false,
            'breakfast_type' => null,
            'parking_available' => false,
            'parking_cost' => null,
            'parking_cost_unit' => null,
            'parking_reservation' => false,
            'parking_location' => null,
            'parking_type' => null,
        ];
    }

    public function casts(): array
    {
        return [
           
        ];
    }
}
