<?php

namespace App\DTOs\Partner;

class HomeEditDTO
{
    public function __construct(
        public readonly ?string $title = null,
        public readonly ?string $description = null,
        public readonly ?string $address = null,
        public readonly ?string $city = null,
        public readonly ?string $country = null,
        public readonly ?string $zipcode = null,
        public readonly ?string $property_type = null,
        public readonly ?int $category_id = null,
        public readonly ?array $amenities = null,
        public readonly ?array $facilities = null,
        public readonly ?array $photos = null,
        public readonly ?string $main_photo = null,
        public readonly ?array $services = null,
        public readonly ?array $languages = null,
        public readonly ?array $house_rules = null,
        public readonly ?array $host_profile = null,
        public readonly ?array $payment_settings = null,
        public readonly ?array $verification = null
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            title: $data['title'] ?? null,
            description: $data['description'] ?? null,
            address: $data['address'] ?? null,
            city: $data['city'] ?? null,
            country: $data['country'] ?? null,
            zipcode: $data['zipcode'] ?? null,
            property_type: $data['property_type'] ?? null,
            category_id: $data['category_id'] ?? null,
            amenities: $data['amenities'] ?? null,
            facilities: $data['facilities'] ?? null,
            photos: $data['photos'] ?? null,
            main_photo: $data['main_photo'] ?? null,
            services: $data['services'] ?? null,
            languages: $data['languages'] ?? null,
            house_rules: $data['house_rules'] ?? null,
            host_profile: $data['host_profile'] ?? null,
            payment_settings: $data['payment_settings'] ?? null,
            verification: $data['verification'] ?? null
        );
    }
}