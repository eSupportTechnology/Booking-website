<?php

namespace App\DTOs\CarRenters;
use App\Models\CarRenter;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class RegisterCarRentersDTO extends ValidatedDTO
{
    // Core fields
    public ?string $email;        // nullable
    public ?string $password;     // nullable
    public ?string $type;         // nullable ('company' or 'individual')

    // Company fields
    public ?string $company_name;
    public ?string $business_reg_no;
    public ?string $company_logo;

    // Individual fields
    public ?string $full_name;
    public ?string $nic_number;

    // Shared fields
    public ?string $phone;
    public ?string $country_code;
    public ?string $address;

    // Validation rules
    protected function rules(): array
    {
        return [
            'email' => ['required', 'email', 'unique:car_renters,email'],
            'password' => ['required', 'string', 'min:10'],
            'type' => ['required', 'in:company,individual'],

            // Company
            'company_name' => ['nullable', 'string', 'max:255'],
            'business_reg_no' => ['nullable', 'string', 'max:255'],
            'company_logo' => ['nullable', 'string', 'max:255'],

            // Individual
            'full_name' => ['nullable', 'string', 'max:255'],
            'nic_number' => ['nullable', 'string', 'max:50'],

            // Shared
            'phone' => ['nullable', 'string', 'max:20'],
            'country_code' => ['nullable', 'string', 'max:10'],
            'address' => ['nullable', 'string'],
        ];
    }

    // Default values
    public function defaults(): array
    {
        return [
            'email' => null,
            'password' => null,
            'type' => null,
            'company_name' => null,
            'business_reg_no' => null,
            'company_logo' => null,
            'full_name' => null,
            'nic_number' => null,
            'phone' => null,
            'country_code' => null,
            'address' => null,
        ];
    }

    // Casting types
    public function casts(): array
    {
        return [
            'email' => '?string',          // note the ? for nullable
            'password' => '?string',
            'type' => '?string',
            'company_name' => '?string',
            'business_reg_no' => '?string',
            'company_logo' => '?string',
            'full_name' => '?string',
            'nic_number' => '?string',
            'phone' => '?string',
            'country_code' => '?string',
            'address' => '?string',
        ];
    }
}
