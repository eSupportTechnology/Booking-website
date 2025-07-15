<?php

namespace App\DTOs\Partner;

use Illuminate\Http\Request;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class PropertyDTO extends ValidatedDTO
{
    protected function rules(): array
    {
        return [];
    }

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [];
    }

    public function __construct(
        public readonly int $user_id,
        public readonly int $category_id,
        public readonly int $subcategory_id,
        public readonly int $subtype_id,
        public readonly int $address_type_id,
        public readonly string $title,
        public readonly string $description,
        public readonly string $address,
        public readonly string $city,
        public readonly string $country,
        public readonly float $latitude,
        public readonly float $longitude,
        public readonly string $status
    ) {}

    public static function fromRequest(Request $request): static
    {
        return new static(
            $request->input('user_id'),
            $request->input('category_id'),
            $request->input('subcategory_id'),
            $request->input('subtype_id'),
            $request->input('address_type_id'),
            $request->input('title'),
            $request->input('description'),
            $request->input('address'),
            $request->input('city'),
            $request->input('country'),
            $request->input('latitude'),
            $request->input('longitude'),
            $request->input('status')
        );
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'subcategory_id' => $this->subcategory_id,
            'subtype_id' => $this->subtype_id,
            'address_type_id' => $this->address_type_id,
            'title' => $this->title,
            'description' => $this->description,
            'address' => $this->address,
            'city' => $this->city,
            'country' => $this->country,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'status' => $this->status,
        ];
    }
}
