<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\PartnerResetPasswordMail;
use Illuminate\Support\Facades\DB;

class PartnerPasswordResetLinkController extends Controller
{
    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        // check if the user is a partner before sending the reset link.
        if (!$user || !$user->hasRole('partner')) {
            return back()->with('error', 'No partner account found with this email address.');
        }

        // create token and send mail.
        $token = app('auth.password.broker')->createToken($user);
        Mail::to($user->email)->send(new PartnerResetPasswordMail($token, $user->email));

        return back()->with('success', 'Password reset link has been sent to your email address.');
    }
} 