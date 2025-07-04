<?php

namespace App\DTOs\Customer\Auth;

use WendellAdriel\ValidatedDTO\ValidatedDTO;
use App\Models\User;

class DeleteCustomerAccountDTO extends ValidatedDTO
{
    public User $user;

    protected function rules(): array
    {
        return [];
    }

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [];
    }
}
