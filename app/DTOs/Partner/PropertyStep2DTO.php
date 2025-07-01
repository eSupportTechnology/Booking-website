<?php

namespace App\DTOs\Partner;

class PropertyStep2DTO
{
    public $title, $address, $city, $country, $zipcode, $description;

    public function __construct($title, $address, $city, $country, $zipcode, $description)
    {
        $this->title = $title;
        $this->address = $address;
        $this->city = $city;
        $this->country = $country;
        $this->zipcode = $zipcode;
        $this->description = $description;
    }

    public static function fromRequest($request)
    {
        return new self(
            $request->input('title'),
            $request->input('address'),
            $request->input('city'),
            $request->input('country'),
            $request->input('zipcode'),
            $request->input('description')
        );
    }

    public function toArray()
    {
        return [
            'title' => $this->title,
            'address' => $this->address,
            'city' => $this->city,
            'country' => $this->country,
            'zipcode' => $this->zipcode,
            'description' => $this->description,
        ];
    }
}
