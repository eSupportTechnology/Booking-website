<?php

namespace App\Http\Controllers\Customer;

use App\Actions\Customer\StoreOrUpdateCustomerPersonalDetailAction;
use App\DTOs\Customer\CustomerPersonalDetailDTO;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerPersonalDetailsController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        $customerDetails = $user->personalDetails;

        $firstName = $user->name;
        $lastName = '';
        if (str_contains($user->name, ' ')) {
            [$firstName, $lastName] = explode(' ', $user->name, 2);
        }

        return view('Customer.customer-personal-profile', [
            'details' => $customerDetails,
            'firstName' => old('first_name', $firstName),
            'lastName' => old('last_name', $lastName),
        ]);
    }

    public function update(Request $request, StoreOrUpdateCustomerPersonalDetailAction $action)
{
    // Get the user
    $user = $request->user();

    // Combine first name and last name from request
    $firstName = $request->input('first_name');
    $lastName = $request->input('last_name');

    // Update the user's name
    $user->name = trim($firstName . ' ' . $lastName);
    $user->save();

    // Create DTO for customer_personal_details
    $dto = CustomerPersonalDetailDTO::fromRequest($request);

    // Save personal details
    $action->execute($dto);

    return redirect()
        ->route('customer.details.create')
        ->with('success', 'Details saved successfully.');
}

}
