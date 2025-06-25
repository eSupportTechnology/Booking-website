<?php

namespace App\DTOs\Customer;

use Illuminate\Http\UploadedFile;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class CustomerPersonalDetailDTO extends ValidatedDTO
{
    public int $user_id;
    public string $display_name;
    public ?string $phone_number;
    public ?string $date_of_birth;
    public ?string $nationality;
    public ?string $gender;
    public ?string $address;
    public ?string $passport_details;
    public ?UploadedFile $profile_image;

    protected function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'display_name' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['nullable', 'date'],
            'nationality' => ['nullable', 'string', 'max:100'],
            'gender' => ['nullable', 'in:male,female,other'],
            'address' => ['nullable', 'string'],
            'passport_details' => ['nullable', 'string'],
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
            'user_id' => 'integer',
            'display_name' => 'string',
            'phone_number' => 'string',
            'date_of_birth' => 'string',
            'nationality' => 'string',
            'gender' => 'string',
            'address' => 'string',
            'passport_details' => 'string',
            'profile_image' => UploadedFile::class,
        ];
    }
}
