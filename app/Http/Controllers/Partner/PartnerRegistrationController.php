<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\DTOs\Partner\RegisterPartnerDTO;
use App\DTOs\Partner\PartnerEmailDTO;
use App\DTOs\Partner\AccommodationDetailsDTO;
use App\Actions\Partner\RegisterPartnerAction;
use App\Actions\Partner\StoreAccommodationDetailsAction;
use App\Models\User;
use Illuminate\Http\Request;

class PartnerRegistrationController extends Controller
{
    /**
     * Show the form to enter an email.
     */
    public function createEmail()
    {
        return view('partner.partner-account-create');
    }

    /**
     * Store the email in the session and redirect to the next step.
     */
    public function storeEmail(Request $request)
    {
        try {
            // Validate email format
            $request->validate([
                'email' => ['required', 'email'],
            ]);

            $email = $request->email;

            // Check if user already exists
            $existingUser = User::where('email', $email)->first();

            // If user is already a partner, redirect to login
            if ($existingUser && $existingUser->isPartner()) {
                return redirect()->route('partner.login')
                    ->with('info', 'You already have a partner account. Please sign in.')
                    ->withInput(['email' => $email]);
            }

            $registrationData = $request->session()->get('partner_registration', []);
            $registrationData['email'] = $email;

            // If user exists as customer, prepare for upgrade
            if ($existingUser) {
                $registrationData['is_upgrade'] = true;
                $registrationData['first_name'] = $existingUser->customerPersonalDetail?->first_name ?? explode(' ', $existingUser->name)[0] ?? '';
                $registrationData['last_name'] = $existingUser->customerPersonalDetail?->last_name ?? explode(' ', $existingUser->name)[1] ?? '';
            }

            $request->session()->put('partner_registration', $registrationData);

            $message = $existingUser
                ? 'Welcome back! We found your existing account. Please continue to become a partner.'
                : 'Email saved successfully. Please continue with your contact details.';

            return redirect()->route('partner.register.contact-details')->with('success', $message);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    /**
     * Register partner with email and password in one step.
     */
    public function registerDirect(Request $request, RegisterPartnerAction $action)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $email = $request->email;

        // Check if user already exists as partner
        $existingUser = User::where('email', $email)->first();

        if ($existingUser && $existingUser->isPartner()) {
            return redirect()->route('partner.login')
                ->with('info', 'You already have a partner account. Please sign in.')
                ->withInput(['email' => $email]);
        }

        // Prepare registration data
        $registrationData = [
            'email' => $email,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
            'name' => $existingUser ? $existingUser->name : explode('@', $email)[0],
            'first_name' => $existingUser ? (explode(' ', $existingUser->name)[0] ?? '') : '',
            'last_name' => $existingUser ? (explode(' ', $existingUser->name)[1] ?? '') : '',
        ];

        // Create DTO and execute action
        $dto = RegisterPartnerDTO::fromArray($registrationData);
        $user = $action->execute($dto);

        // If existing user is already verified, log them in
        if ($existingUser && $user->hasVerifiedEmail()) {
            auth()->login($user);
            return redirect()->route('partner.dashboard')
                ->with('success', 'Welcome! Your account has been upgraded to Partner.');
        }

        // For new users, trigger email verification
        if (!$user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
        }

        // Store email in session for verification page
        $request->session()->put('partner_registration.email', $email);

        return redirect()->route('partner.register.verify');
    }

    /**
     * Show the form to enter contact details.
     */
    public function createContact()
    {
        if (!session()->has('partner_registration.email')) {
            return redirect()->route('partner.register.email-create')->with('error', 'Please enter your email first.');
        }
        return view('partner.partner-contact-details');
    }

    /**
     * Store contact details in the session and redirect to the next step.
     */
    public function storeContact(Request $request)
    {
        $registrationData = $request->session()->get('partner_registration', []);
        $contactData = $request->only(['first_name', 'last_name', 'contact_number']);
        $registrationData = array_merge($registrationData, $contactData);
        $request->session()->put('partner_registration', $registrationData);

        return redirect()->route('partner.register.password-create');
    }

    /**
     * Show the form to create a password.
     */
    public function createPassword()
    {
        if (!session()->has('partner_registration.first_name')) {
            return redirect()->route('partner.register.contact-details')->with('error', 'Please enter your contact details.');
        }
        return view('partner.partner-create-password');
    }

    /**
     * Store password, validate all data, register partner, and send verification.
     */
    public function register(Request $request, RegisterPartnerAction $action)
    {
        $registrationData = $request->session()->get('partner_registration', []);

        // Add password and name to the data
        $registrationData['password'] = $request->password;
        $registrationData['password_confirmation'] = $request->password_confirmation;
        $registrationData['name'] = ($registrationData['first_name'] ?? '') . ' ' . ($registrationData['last_name'] ?? '');

        // Check if this is an existing user upgrading to partner
        $existingUser = User::where('email', $registrationData['email'] ?? '')->first();
        $isUpgrade = $existingUser !== null;

        // Create DTO from the complete data array for final validation
        $dto = RegisterPartnerDTO::fromArray($registrationData);

        // Execute the action to create/upgrade the user and partner
        $user = $action->execute($dto);

        // Clear the session data
        $request->session()->forget('partner_registration');

        // If existing user is already verified, log them in and redirect to dashboard
        if ($isUpgrade && $user->hasVerifiedEmail()) {
            auth()->login($user);
            return redirect()->route('partner.dashboard')
                ->with('success', 'Welcome! Your account has been upgraded to Partner. You can now list your properties.');
        }

        // For new users, trigger email verification
        if (!$user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
        }

        // Redirect to verification notice page
        return redirect()->route('partner.register.verify');
    }

    /**
     * Store accommodation, business entity, individual, and alt name details.
     */
    public function storeAccommodationDetails(Request $request, StoreAccommodationDetailsAction $action)
    {
        try {
            $dto = AccommodationDetailsDTO::fromRequest($request);
            $accommodation = $action->execute($dto);
            return response()->json([
                'success' => true,
                'accommodation_id' => $accommodation->id,
                'message' => 'Accommodation details saved successfully.'
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}