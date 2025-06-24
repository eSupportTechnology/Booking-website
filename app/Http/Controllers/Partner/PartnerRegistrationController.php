<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\DTOs\Partner\RegisterPartnerDTO;
use App\Actions\Partner\RegisterPartnerAction;
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
        $registrationData = $request->session()->get('partner_registration', []);
        $registrationData['email'] = $request->input('email');
        $request->session()->put('partner_registration', $registrationData);

        return redirect()->route('partner.register.contact-details');
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

        // Create DTO from the complete data array for final validation
        $dto = RegisterPartnerDTO::fromArray($registrationData);

        // Execute the action to create the user and partner
        $user = $action->execute($dto);

        // Trigger email verification
        $user->sendEmailVerificationNotification();

        // Clear the session data
        $request->session()->forget('partner_registration');

        // Redirect to Laravel's built-in verification notice page
        return redirect()->route('partner.register.verify');
    }
}
// This controller handles the registration of partners by accepting a DTO and executing the registration action.