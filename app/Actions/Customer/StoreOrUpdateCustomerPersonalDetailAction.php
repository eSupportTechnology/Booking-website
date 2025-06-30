<?php

namespace App\Actions\Customer;

use App\DTOs\Customer\CustomerPersonalDetailDTO;
use App\Models\CustomerPersonalDetails;
use Illuminate\Support\Facades\Storage;

class StoreOrUpdateCustomerPersonalDetailAction
{
    public function execute(CustomerPersonalDetailDTO $dto): CustomerPersonalDetails
    {
        $data = $dto->toArray();

        if ($dto->profile_image) {
            $data['profile_image'] = $dto->profile_image->store('customer_profiles', 'public');
        }

        // Find by user_id, update if exists, else create new
        return CustomerPersonalDetails::updateOrCreate(
            ['user_id' => $dto->user_id], // search by user_id
            $data
        );
    }
}
