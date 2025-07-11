<?php

namespace App\Http\Controllers\Customer;

use App\Actions\Customer\StoreOrUpdateCustomerPersonalDetailAction;
use App\DTOs\Customer\CustomerPersonalDetailDTO;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerPersonalDetailsController extends Controller
{
    public function edit()
    {
        $user = Auth::guard('customer')->user();

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        $customerDetails = $user->customerPersonalDetail ?? null;

        $firstName = $user->name;
        $lastName = '';
        if (str_contains($user->name, ' ')) {
            [$firstName, $lastName] = explode(' ', $user->name, 2);
        }

        // Split passport name
        $passportName = $customerDetails?->passport_name ?? '';
        $passportParts = explode(' ', $passportName, 2);
        $passportFirstName = $passportParts[0] ?? '';
        $passportLastName = $passportParts[1] ?? '';

        // Split passport expiry date
        $passportExpiryDate = $customerDetails?->passport_expiry_date;
        $passportExpiryDay = '';
        $passportExpiryMonth = '';
        $passportExpiryYear = '';

        if ($passportExpiryDate) {
            try {
                $date = Carbon::parse($passportExpiryDate);
                $passportExpiryDay = $date->format('d');
                $passportExpiryMonth = $date->format('m');
                $passportExpiryYear = $date->format('Y');
            } catch (\Exception $e) {
            }
        }

        return view('Customer.customer-personal-profile', [
            'details' => $customerDetails,
            'firstName' => old('first_name', $firstName),
            'lastName' => old('last_name', $lastName),
            'email' => old('email', $user->email),
            'emailVerified' => $user->email_verified_at !== null,
            'passportFirstName' => old('passportFirstName', $passportFirstName),
            'passportLastName' => old('passportLastName', $passportLastName),
            'passportExpiryDay' => old('passportExpiryDay', $passportExpiryDay),
            'passportExpiryMonth' => old('passportExpiryMonth', $passportExpiryMonth),
            'passportExpiryYear' => old('passportExpiryYear', $passportExpiryYear),
        ]);
    }

    public function update(Request $request, StoreOrUpdateCustomerPersonalDetailAction $action)
    {
        $user = Auth::guard('customer')->user();

        if (!$user) {
            abort(403, 'Unauthorized action.');
        }

        // Update user's name if provided
        if ($request->has(['first_name', 'last_name'])) {
            $user->name = trim($request->input('first_name') . ' ' . $request->input('last_name'));
        }

        // Handle email verification status
        $emailVerified = false;
        $emailToSave = $user->email; // Keep current email by default

        // Check if email was verified through the verification process
        if ($request->filled('email_verified') && $request->boolean('email_verified')) {
            $emailToSave = $request->input('email');
            $emailVerified = true;
        } elseif ($request->filled('email') && $request->input('email') === $user->email && $user->email_verified_at) {
            // Email hasn't changed and was already verified
            $emailVerified = true;
        }

        // Only update email if it's been verified or if it's the same as current verified email
        if ($emailVerified || ($request->filled('email') && $request->input('email') === $user->email)) {
            $user->email = $emailToSave;
            if ($emailVerified && !$user->email_verified_at) {
                $user->email_verified_at = now();
            }
        }

        $user->save();

        $existingDetail = $user->customerPersonalDetail;

        // Preserve display_name if not present in request
        if (!$request->has('display_name') && $existingDetail) {
            $request->merge([
                'display_name' => $existingDetail->display_name,
            ]);
        }

        // Handle phone number - only save if verified
        $phoneNumber = null;
        $phoneVerified = false;

        if ($request->filled('phone_number') && $request->boolean('phone_verified')) {
            $phoneNumber = $request->input('phone_number');
            $phoneVerified = true;
        } elseif ($existingDetail && $existingDetail->phone_verified) {
            // Keep existing verified phone number
            $phoneNumber = $existingDetail->phone_number;
            $phoneVerified = true;
        }

        // Combine passport name
        $passportFirstName = $request->input('passportFirstName');
        $passportLastName = $request->input('passportLastName');

        if ($passportFirstName || $passportLastName) {
            $passportName = trim("{$passportFirstName} {$passportLastName}");
            $request->merge(['passport_name' => $passportName]);
        } elseif ($existingDetail) {
            $request->merge(['passport_name' => $existingDetail->passport_name]);
        }

        // Combine passport expiry date
        $day = $request->input('passportExpiryDay');
        $month = $request->input('passportExpiryMonth');
        $year = $request->input('passportExpiryYear');

        if ($day && $month && $year) {
            $passportExpiryDate = "{$year}-{$month}-{$day}";
            if (strtotime($passportExpiryDate)) {
                $request->merge(['passport_expiry_date' => $passportExpiryDate]);
            }
        }

        // Merge user_id, phone number, and verification status
        $requestData = array_merge(
            $request->all(),
            [
                'user_id' => $user->id,
                'phone_number' => $phoneNumber,
                'phone_verified' => $phoneVerified,
                'email_verified' => $emailVerified
            ]
        );

        if ($request->hasFile('profile_image')) {
            $requestData['profile_image'] = $request->file('profile_image');
        }

        // Pass data to DTO and action
        $dto = new CustomerPersonalDetailDTO($requestData);
        $action->execute($dto);

        // Return JSON response for AJAX requests
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Details saved successfully.',
                'phone_verified' => $phoneVerified,
                'phone_number' => $phoneNumber,
                'email_verified' => $emailVerified,
                'email' => $user->email
            ]);
        }

        return redirect()
            ->route('customer.details.create')
            ->with('success', 'Details saved successfully.');
    }
}
