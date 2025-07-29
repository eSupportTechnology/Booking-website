<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\LoginAction;
use App\Actions\Admin\RegisterAction;
use App\DTOs\Admin\LoginDTO;
use App\DTOs\Admin\RegisterDTO;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.admin-login');
    }

    public function login(Request $request, LoginAction $action)
    {
        $dto = LoginDTO::fromRequest($request);

        if ($action->execute($dto)) {
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['username' => 'Invalid credentials or account not approved.']);
    }

    public function showRegister()
    {
        return view('admin.admin-registration');
    }

    public function register(Request $request, RegisterAction $action)
    {
        $dto = RegisterDTO::fromRequest($request);
        $admin = $action->execute($dto);

        return redirect()->route('admin.login')->with('status', 'Registration submitted! Please wait for super admin approval.');
    }

    public function showForgotPassword()
    {
        return view('admin.admin-forgot-password');
    }

    public function forgotPassword(Request $request)
    {
        return redirect()->route('admin.forgot-password');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
