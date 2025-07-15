<?php

namespace App\DTOs\Customer;

use Illuminate\Http\UploadedFile;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class CustomerPersonalDetailDTO extends ValidatedDTO
{
    public int $user_id;
    public ?string $display_name;
    public ?string $phone_number;
    public ?string $date_of_birth;
    public ?string $nationality;
    public ?string $gender;
    public ?string $country;
    public ?string $street;
    public ?string $city;
    public ?string $postcode;
    public ?string $passport_name;
    public ?string $issuingCountry;
    public ?string $passportNumber;
    public ?string $passport_expiry_date;
    public ?UploadedFile $profile_image;

    protected function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'display_name' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['nullable', 'date'],
            'nationality' => ['nullable', 'string', 'max:100'],
            'gender' => ['nullable', 'in:male,female,other'],
            'country' => ['nullable', 'string'],
            'street' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'postcode' => ['nullable', 'string'],
            'passport_name' => ['nullable', 'string', 'max:255'],
            'issuingCountry' => ['nullable', 'string', 'max:100'],
            'passportNumber' => ['nullable', 'string', 'max:50'],
            'passport_expiry_date' => ['nullable', 'date'],
            'profile_image' => ['nullable', 'image', 'max:2048'],
        ];
    }

    protected function defaults(): array
    {
        return [
            'profile_image' => null,
        ];
    }

    protected function casts(): array
    {
        return [
            // 'profile_image' => UploadedFile::class,
        ];
    }
}
