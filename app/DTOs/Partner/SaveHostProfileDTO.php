<?php

namespace App\DTOs\Partner;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class SaveHostProfileDTO extends ValidatedDTO
{
    public int $property_id;
    public ?string $about_property;
    public ?string $about_host;
    public ?string $about_neighborhood;
    public bool $show_property;
    public bool $show_host;
    public bool $show_neighborhood;
    public bool $none_selected;
    public ?string $host_name;

    protected function rules(): array
    {
        return [
            'property_id' => ['required', 'exists:properties,id'],
            'about_property' => ['nullable', 'string', 'max:1000'],
            'about_host' => ['nullable', 'string', 'max:1000'],
            'about_neighborhood' => ['nullable', 'string', 'max:1000'],
            'show_property' => ['required', 'boolean'],
            'show_host' => ['required', 'boolean'],
            'show_neighborhood' => ['required', 'boolean'],
            'none_selected' => ['required', 'boolean'],
            'host_name' => ['nullable', 'string', 'max:255'],
        ];
    }

    protected function defaults(): array
    {
        return [
            'about_property' => null,
            'about_host' => null,
            'about_neighborhood' => null,
            'show_property' => false,
            'show_host' => false,
            'show_neighborhood' => false,
            'none_selected' => false,
            'host_name' => null,
        ];
    }

    protected function casts(): array
    {
        return [
            // 'property_id' => 'integer',
            // 'show_property' => 'boolean',
            // 'show_host' => 'boolean',
            // 'show_neighborhood' => 'boolean',
            // 'none_selected' => 'boolean',
        ];
    }
} 