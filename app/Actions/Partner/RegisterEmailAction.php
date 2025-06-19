<?php

// app/Actions/RegisterEmailAction.php

namespace App\Actions\Partner;

use App\DTOs\Partner\RegisterEmailDTO;
use App\Models\PartnerRegistration;
use Illuminate\Support\Str;

class RegisterEmailAction
{
    public function execute(RegisterEmailDTO $dto): PartnerRegistration
    {
        return PartnerRegistration::updateOrCreate(
            ['email' => $dto->email],
            ['verification_token' => Str::uuid()]
        );
    }
}
