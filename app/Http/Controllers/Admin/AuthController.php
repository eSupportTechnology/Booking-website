<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\LoginAction;
use App\Actions\Admin\RegisterAction;
use App\Actions\Admin\ForgotPasswordAction;
use App\DTOs\Admin\LoginDTO;
use App\DTOs\Admin\RegisterDTO;
use App\DTOs\Admin\ForgotPasswordDTO;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request, LoginAction $action)
    {
        $dto = LoginDTO::fromRequest($request);

        if ($action->execute($dto)) {
            $user = Auth::user();

            if (!$user->hasRole(['admin', 'super-admin'])) {
                Auth::logout();
                return back()->withErrors(['email' => 'Unauthorized access.']);
            }

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function showRegister()
    {
        return view('admin.Registration');
    }

    public function register(Request $request, RegisterAction $action)
    {
        $dto = RegisterDTO::fromRequest($request);
        $user = $action->execute($dto);

        return redirect()->route('admin.login')->with('status', 'Registration successful! Please login.');
    }

    public function showForgotPassword()
    {
        return view('admin.ForgotPassword');
    }

    public function forgotPassword(Request $request, ForgotPasswordAction $action)
    {
        $dto = ForgotPasswordDTO::fromRequest($request);
        $status = $action->execute($dto);

        return $status === 'passwords.sent'
            ? back()->with('status', 'Password reset link sent!')
            : back()->withErrors(['email' => 'Unable to send reset link.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
