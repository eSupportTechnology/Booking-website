<?php

namespace App\Actions\Admin;

use App\DTOs\Admin\ForgotPasswordDTO;
use App\Models\Admin;
use Illuminate\Support\Facades\Password;

class ForgotPasswordAction
{
    public function execute(ForgotPasswordDTO $dto): string
    {
        $admin = Admin::where('username', $dto->username)->first();
        
        if (!$admin) {
            return 'passwords.user';
        }
        
        return Password::broker('admins')->sendResetLink(['email' => $admin->email]);
    }
}