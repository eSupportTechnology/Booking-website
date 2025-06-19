<?php

// app/Actions/RegisterPasswordAction.php

namespace App\Actions\Partner;

use App\DTOs\Partner\RegisterPasswordDTO;
use App\Models\PartnerRegistration;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\PartnerVerificationMail;

class RegisterPasswordAction
{
    public function execute(RegisterPasswordDTO $dto): PartnerRegistration
    {
        $registration = PartnerRegistration::where('email', $dto->email)->firstOrFail();

        $token = Str::uuid();
        $registration->update([
            'password' => Hash::make($dto->password),
            'verification_token' => $token,
        ]);

        // Generate link
        $verificationUrl = url("/partner/register/verify/{$token}");

        // Send email
        Mail::to($registration->email)->send(new PartnerVerificationMail($verificationUrl));

        return $registration;
    }
}
