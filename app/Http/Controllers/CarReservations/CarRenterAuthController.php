<?php

namespace App\Http\Controllers\CarReservations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DTOs\CarRenters\RegisterCarRentersDTO;
use App\DTOs\CarRenters\CarRentersEmailDTO;
use App\Actions\CarRenters\RegisterCarRentersAction; 

use App\Models\CarRenter;

class CarRenterAuthController extends Controller
{
    // Show email form
    public function createEmail()
    {
        return view('car_rentals.carrental-account-create');
    }

    // Store email in session
    public function storeEmail(Request $request)
    {
        $dto = CarRentersEmailDTO::fromRequest($request);
        $registrationData = $request->session()->get('car_renter_registration', []);
        $registrationData['email'] = $dto->email;
        $request->session()->put('car_renter_registration', $registrationData);

        return redirect()
            ->route('car_renter.register.details')
            ->with('success', 'Email saved successfully. Please continue with your details.');
    }

    // Show contact details form
    public function carRenterDetails()
    {
        if (!session()->has('car_renter_registration.email')) {
            return redirect()
                ->route('car_renter.register.email')
                ->with('error', 'Please enter your email first.');
        }
        return view('car_rentals.carrental-registration');
    }

    // Store company details
    public function storeCompanyDetails(Request $request)
    {
        $request->validate([
            'company_name'  => 'required|string|max:255',
            'company_email' => 'required|email',
            'phone'         => 'required|string|max:20',
            'logo'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $registrationData = $request->session()->get('car_renter_registration', []);
        $companyData = $request->only(['company_name','business_reg','company_email','phone','address']);

        if ($request->hasFile('logo')) {
            $companyData['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $registrationData = array_merge($registrationData, ['type' => 'company'], $companyData);
        $request->session()->put('car_renter_registration', $registrationData);

        return redirect()->route('carrentals.register.password');
    }

    // Store individual details
    public function storeIndividualDetails(Request $request)
    {
        $request->validate([
            'full_name'         => 'required|string|max:255',
            'individual_email'  => 'required|email',
            'individual_phone'  => 'required|string|max:20',
            'individual_nic'    => 'required|string|max:20',
        ]);

        $registrationData = $request->session()->get('car_renter_registration', []);
        $individualData = $request->only(['full_name','individual_email','individual_phone','individual_nic','individual_address']);
        $registrationData = array_merge($registrationData, ['type' => 'individual'], $individualData);

        $request->session()->put('car_renter_registration', $registrationData);

        return redirect()->route('carrentals.register.password');
    }

    // Show password form
    public function createPassword()
    {
        if (!session()->has('car_renter_registration')) {
            return redirect()
                ->route('car_renter.register.details')
                ->with('error', 'Please complete your registration details first.');
        }

        $data = session('car_renter_registration');
        if (($data['type'] === 'company' && empty($data['company_name'])) ||
            ($data['type'] === 'individual' && empty($data['full_name']))) {
            return redirect()
                ->route('car_renter.register.details')
                ->with('error', 'Please complete your registration details first.');
        }

        return view('car_rentals.carrental-create-password');
    }

    // Store password and complete registration
    public function register(Request $request, RegisterCarRentersAction $action)
    {
        $request->validate([
            'password' => 'required|string|min:10|confirmed',
        ]);

        $registrationData = $request->session()->get('car_renter_registration', []);
        if (empty($registrationData)) {
            return redirect()
                ->route('car_renter.register.details')
                ->with('error', 'Please complete your registration before creating a password.');
        }

        $registrationData['password'] = $request->password;

        // Store email separately before clearing session
        $email = $registrationData['email'];
  
        $dto = RegisterCarRentersDTO::fromArray($registrationData);
        $user = $action->execute($dto);
        $user->sendEmailVerificationNotification();

        // Clear session and save email
        $request->session()->forget('car_renter_registration');
        $request->session()->put('car_renter_email', $email);

        return redirect()->route('carrentals.register.email.verify');
    }

    // Email verification page
    public function emailVerifyPage(Request $request)
    {
        $email = $request->session()->get('car_renter_email');
        return view('car_rentals.email-verify', compact('email'));
    }

    // Resend verification email
    public function resendVerificationEmail()
    {
        // Placeholder
        return response()->json([
            'status' => 'success',
            'message' => 'Verification email resent (placeholder).'
        ]);
    }

    // Verify user email by token
    public function verify($token)
    {
        // Add your verification logic here
        return redirect()->route('login')->with('success', 'Email verified successfully.');
    }
}
