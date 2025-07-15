<?php

namespace App\Actions\Customer\Auth;

use App\DTOs\Customer\Auth\RequestAccountDeletionDTO;
use App\Mail\AccountDeletionConfirmation;
use App\Models\CustomerAccountDeletionToken;
use Illuminate\Support\Facades\Mail;

class RequestAccountDeletionAction
{
    public function execute(RequestAccountDeletionDTO $dto): void
    {
        $user = $dto->user;

        // Generate deletion token
        $token = CustomerAccountDeletionToken::createToken($user->email);

        // Send confirmation email
        Mail::to($user->email)->send(new AccountDeletionConfirmation($user, $token));
    }
}
