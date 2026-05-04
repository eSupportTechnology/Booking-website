<?php

namespace App\DTOs\Partner;

use Illuminate\Http\UploadedFile;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class UploadPropertyPhotosDTO extends ValidatedDTO
{
    public  $property_id;

    /** @var UploadedFile[] */
    public array $photos;

    public function rules(): array
    {
        return [
            'property_id' => ['required', 'exists:properties,id'],
            'photos' => ['required', 'array'],
            'photos.*' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:51200'], // 50MB max per file
        ];
    }

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [
          
        ];
    }
}
