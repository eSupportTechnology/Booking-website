<?php

// app/Actions/RegisterContactAction.php

namespace App\Actions\Partner;

use App\DTOs\Partner\RegisterContactDTO;
use App\Models\PartnerRegistration;

class RegisterContactAction
{
    public function execute(RegisterContactDTO $dto): PartnerRegistration
    {
        $registration = PartnerRegistration::where('email', $dto->email)->firstOrFail();

        $registration->update([
            'first_name' => $dto->first_name,
            'last_name' => $dto->last_name,
            'contact_number' => $dto->contact_number,
        ]);

        return $registration;
    }
}
