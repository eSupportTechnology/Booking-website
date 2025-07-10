<?php

namespace App\Actions\Customer\Auth;

use App\DTOs\Customer\Auth\DeleteCustomerAccountDTO;
use App\Models\CustomerAccountDeletionToken;
use Illuminate\Support\Facades\Auth;

class DeleteCustomerAccountAction
{
    public function execute(DeleteCustomerAccountDTO $dto): void
    {
        $user = $dto->user;

        // Delete related details (soft delete if the model supports it)
        if ($user->customerPersonalDetail) {
            $user->customerPersonalDetail->delete();
        }

        // Soft delete user (assuming User model uses SoftDeletes trait)
        $user->delete();

        // Clean up deletion tokens
        CustomerAccountDeletionToken::where('email', $user->email)->delete();

        // Logout if user is currently authenticated
        if (Auth::guard('customer')->check()) {
            Auth::guard('customer')->logout();
        }
    }
}
