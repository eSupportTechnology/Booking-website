<?php

namespace App\Actions\CarRenters;

use App\DTOs\CarRenters\RegisterCarRentersDTO;
use App\Models\CarRenter;
use Illuminate\Support\Facades\Hash;

class RegisterCarRentersAction
{
    public function execute(RegisterCarRentersDTO $dto): CarRenter
    {
        return CarRenter::create([
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
            'account_type' => $dto->account_type, // ✅ now matches DTO

            'company_name' => $dto->company_name,
            'business_reg_no' => $dto->business_reg_no,
            'company_logo' => $dto->company_logo,

            'full_name' => $dto->full_name,
            'nic_number' => $dto->nic_number,

            'phone' => $dto->phone,
            'country_code' => $dto->country_code,
            'address' => $dto->address,
        ]);
    }
}
