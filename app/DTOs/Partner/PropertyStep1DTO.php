<?php

namespace App\DTOs\Partner;

class PropertyStep1DTO
{
    public $user_id, $category_id, $subcategory_id, $property_count, $address_type_id;

    public function __construct($user_id, $category_id, $subcategory_id, $property_count = null, $address_type_id = null)
    {
        $this->user_id = $user_id;
        $this->category_id = $category_id;
        $this->subcategory_id = $subcategory_id;
        $this->property_count = $property_count;
        $this->address_type_id = $address_type_id;
    }

    public static function fromRequest($request)
    {
        return new self(
            $request->input('user_id'),
            $request->input('category_id'),
            $request->input('subcategory_id'),
            $request->input('property_count'),
            $request->input('address_type_id')
        );
    }

    public function toArray()
    {
        return [
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'subcategory_id' => $this->subcategory_id,
            'property_count' => $this->property_count,
            'address_type_id' => $this->address_type_id,
        ];
    }
}
