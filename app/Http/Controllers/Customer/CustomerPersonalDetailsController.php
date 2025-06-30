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
        $user = Auth::user();
        $customerDetails = $user->customerPersonalDetail;

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
            'passportFirstName' => old('passportFirstName', $passportFirstName),
            'passportLastName' => old('passportLastName', $passportLastName),
            'passportExpiryDay' => old('passportExpiryDay', $passportExpiryDay),
            'passportExpiryMonth' => old('passportExpiryMonth', $passportExpiryMonth),
            'passportExpiryYear' => old('passportExpiryYear', $passportExpiryYear),
        ]);
    }


    public function update(Request $request, StoreOrUpdateCustomerPersonalDetailAction $action)
    {
        $user = $request->user();

        // Update name/email if present
        if ($request->has(['first_name', 'last_name'])) {
            $user->name = trim($request->input('first_name', '') . ' ' . $request->input('last_name', ''));
        }
        if ($request->filled('email')) {
            $user->email = $request->input('email');
        }
        $user->save();

        $existingDetail = $user->customerPersonalDetail;

        if (!$request->has('display_name') && $existingDetail) {
            $request->merge(['display_name' => $existingDetail->display_name]);
        }

        $passportFirstName = $request->input('passportFirstName');
        $passportLastName = $request->input('passportLastName');

        if ($passportFirstName || $passportLastName) {
            $passportName = trim("{$passportFirstName} {$passportLastName}");
            $request->merge(['passport_name' => $passportName]);
        } elseif ($existingDetail) {
            $request->merge(['passport_name' => $existingDetail->passport_name]);
        }


        $day = $request->input('passportExpiryDay');
        $month = $request->input('passportExpiryMonth');
        $year = $request->input('passportExpiryYear');

        if ($day && $month && $year) {
            $passportExpiryDate = "{$year}-{$month}-{$day}";

            if (strtotime($passportExpiryDate)) {
                $request->merge(['passport_expiry_date' => $passportExpiryDate]);
            }
        }

        $request->merge(['user_id' => $user->id]);

        $dto = CustomerPersonalDetailDTO::fromRequest($request);

        $action->execute($dto);

        return redirect()
            ->route('customer.details.create')
            ->with('success', 'Details saved successfully.');
    }
}
