<?php

namespace App\Actions\Customer;

use App\DTOs\Customer\CustomerPersonalDetailDTO;
use App\Models\CustomerPersonalDetails;
use Illuminate\Support\Facades\Storage;

class StoreOrUpdateCustomerPersonalDetailAction
{
    public function execute(CustomerPersonalDetailDTO $dto): CustomerPersonalDetails
{
    $data = array_filter($dto->toArray(), function($value) {
        return $value !== null; // Keep only non-null fields to update
    });

    if (isset($data['profile_image']) && $dto->profile_image) {
        $data['profile_image'] = $dto->profile_image->store('customer_profiles', 'public');
    }

    return CustomerPersonalDetails::updateOrCreate(
        ['user_id' => $dto->user_id],
        $data
    );
}

}
