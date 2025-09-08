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
    
    // Show contact details form
    public function carRenterDetails()
    {
       
        return view('car_rentals.carrental-registration');
    }

    // Store company details
    public function storeCompanyDetails(Request $request)
    {
        $request->validate([
            'company_name'  => 'required|string|max:255',
            'company_email' => 'required|email',
            'phone'         => 'required|string|max:20',
            'business_reg_no'  => 'required|string|max:100',
            'tin_number'       => 'required|string|max:100',
            'logo'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $registrationData = $request->session()->get('car_renter_registration', []);

        $companyData = [
            'company_name'     => $request->company_name,
            'business_reg_no'  => $request->business_reg,
            'tin_number'       => $request->tin_number,
            'email'            => $request->company_email,
            'phone'            => $request->phone,
            'address'          => $request->address,
        ];

        if ($request->hasFile('logo')) {
            $companyData['company_logo'] = $request->file('logo')->store('logos', 'public');
        }

        $registrationData = array_merge($registrationData, ['account_type' => 'company'], $companyData);
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
            'individual_phone2' => 'required|string|max:20',
            'individual_nic'    => 'required|string|max:20',
        ]);

        $registrationData = $request->session()->get('car_renter_registration', []);

        $individualData = [
            'full_name'   => $request->full_name,
            'nic_number'  => $request->individual_nic,
            'email'       => $request->individual_email,
            'phone'       => $request->individual_phone,
            'phone2'      => $request->individual_phone2,
            'address'     => $request->individual_address,
        ];

        $registrationData = array_merge($registrationData, ['account_type' => 'individual'], $individualData);
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
        if (($data['account_type'] === 'company' && empty($data['company_name'])) ||
            ($data['account_type'] === 'individual' && empty($data['full_name']))) {
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

        $email = $registrationData['email'];
  
        $dto = RegisterCarRentersDTO::fromArray($registrationData);
        $user = $action->execute($dto);
        $user->sendEmailVerificationNotification();

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
        return response()->json([
            'status' => 'success',
            'message' => 'Verification email resent (placeholder).'
        ]);
    }

    // Verify user email by token
    public function verify($token)
    {
        return redirect()->route('login')->with('success', 'Email verified successfully.');
    }
}
