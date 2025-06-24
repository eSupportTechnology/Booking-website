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
use Illuminate\Support\Facades\Log;

class PartnerRegistrationController extends Controller
{
    public function registerEmail(Request $request, RegisterEmailAction $action)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => [
                    'required',
                    'email',
                    'unique:partner_registrations,email',
                    'unique:users,email',
                ],
            ], [
                'email.unique' => 'This email is already registered. Please log in or use a different email.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first('email')
                ], 422);
            }

            $dto = RegisterEmailDTO::fromRequest($request);
            $registration = $action->execute($dto);

            return response()->json([
                'status' => 'success',
                'message' => 'Email registered. Continue with contact details.',
                'id' => $registration->id,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
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
        Log::info('Partner verification started', ['token' => $token]);
        $registration = PartnerRegistration::where('verification_token', $token)->first();
        if (!$registration) {
            Log::error('Partner verification failed: registration not found', ['token' => $token]);
            abort(404, 'Verification token not found.');
        }

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $registration->first_name . ' ' . $registration->last_name,
                'email' => $registration->email,
                'password' => $registration->password, // already hashed
                'email_verified_at' => Carbon::now(),
            ]);
            Log::info('User created in users table', ['user_id' => $user->id, 'email' => $user->email]);

            $user->assignRole('partner');
            Log::info('Partner role assigned', ['user_id' => $user->id]);

            // Optional: delete registration
            $registration->delete();
            Log::info('Partner registration deleted', ['registration_id' => $registration->id]);

            DB::commit();

            // Log in the user (optional, but recommended for a smooth UX)
            \Illuminate\Support\Facades\Auth::login($user);
            Log::info('User logged in', ['user_id' => $user->id]);

            // Redirect to the partner home/list-your-property page
            return redirect()->route('partner.list-your-property');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Verification failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect('/')->with('error', 'Verification failed: ' . $e->getMessage());
        }
    }
}
