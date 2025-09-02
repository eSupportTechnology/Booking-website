<?php

namespace App\DTOs\CarRenters;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class RegisterCarRentersDTO extends ValidatedDTO
{
    // Core fields
    public ?string $email;
    public ?string $password;
    public ?string $account_type; // ✅ renamed from "type"

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

    protected function rules(): array
    {
        return [
            'email' => ['required', 'email', 'unique:car_renters,email'],
            'password' => ['required', 'string', 'min:10'],
            'account_type' => ['required', 'in:company,individual'], // ✅ fixed name

            'company_name' => ['nullable', 'string', 'max:255'],
            'business_reg_no' => ['nullable', 'string', 'max:255'],
            'company_logo' => ['nullable', 'string', 'max:255'],

            'full_name' => ['nullable', 'string', 'max:255'],
            'nic_number' => ['nullable', 'string', 'max:50'],

            'phone' => ['nullable', 'string', 'max:20'],
            'country_code' => ['nullable', 'string', 'max:10'],
            'address' => ['nullable', 'string'],
        ];
    }

    public function defaults(): array
    {
        return [
            'email' => null,
            'password' => null,
            'account_type' => null, // ✅ fixed
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

    public function casts(): array
    {
        return [];
    }
}
