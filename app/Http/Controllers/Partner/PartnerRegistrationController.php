<?php

// app/Http/Controllers/PartnerRegistrationController.php

namespace App\Http\Controllers\Partner;

use App\Models\PartnerRegistration;
use App\DTOs\Partner\RegisterEmailDTO;
use App\Actions\Partner\RegisterEmailAction;
use App\DTOs\Partner\RegisterContactDTO;
use App\Actions\Partner\RegisterContactAction;
use App\DTOs\Partner\RegisterPasswordDTO;
use App\Actions\Partner\RegisterPasswordAction;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use App\Models\User;
use Illuminate\Routing\Controller;

class PartnerRegistrationController extends Controller
{
    public function registerEmail(Request $request, RegisterEmailAction $action)
    {
        $request->validate([
            'email' => 'required|email|unique:partner_registrations,email',
        ]);

        $dto = RegisterEmailDTO::fromRequest($request);
        $registration = $action->execute($dto);

        return response()->json([
            'message' => 'Email registered. Continue with contact details.',
            'id' => $registration->id,
        ]);
    }

    public function registerContact(Request $request, RegisterContactAction $action)
    {
        $request->validate([
            'email' => 'required|email|exists:partner_registrations,email',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
        ]);

        $dto = RegisterContactDTO::fromRequest($request);
        $registration = $action->execute($dto);

        return response()->json([
            'status' => 'success',
            'message' => 'Contact details saved. Continue with password setup.',
            'id' => $registration->id,
        ]);
    }

    public function registerPassword(Request $request, RegisterPasswordAction $action)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:partner_registrations,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            // Always return JSON for AJAX
            throw new HttpResponseException(
                response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors(),
                ], 422)
            );
        }

        $dto = RegisterPasswordDTO::fromRequest($request);
        $registration = $action->execute($dto);

        return response()->json([
            'status' => 'success',
            'message' => 'Password set. Proceed to verify email.',
            'verification_token' => $registration->verification_token,
        ]);
    }

    public function verify($token)
    {
        $registration = PartnerRegistration::where('verification_token', $token)->firstOrFail();

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $registration->first_name . ' ' . $registration->last_name,
                'email' => $registration->email,
                'password' => $registration->password, // already hashed
                'email_verified_at' => Carbon::now(),
            ]);

            $user->assignRole('partner');

            // Optional: delete registration
            $registration->delete();

            DB::commit();

            // Log in the user (optional, but recommended for a smooth UX)
            \Illuminate\Support\Facades\Auth::login($user);

            // Redirect to the partner home/list-your-property page
            return redirect()->route('partner.list-your-property');
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect('/')->with('error', 'Verification failed: ' . $e->getMessage());
        }
    }
}
