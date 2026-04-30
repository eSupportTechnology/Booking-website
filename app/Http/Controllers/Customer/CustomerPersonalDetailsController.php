<?php

namespace App\Http\Controllers\Customer;

use App\Actions\Customer\StoreOrUpdateCustomerPersonalDetailAction;
use App\DTOs\Customer\CustomerPersonalDetailDTO;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CustomerPersonalDetailsController extends Controller
{
    /**
     * Update profile image using base64 data
     */
    public function updateProfileImage(Request $request)
    {
        try {
            $user = Auth::guard('customer')->user();

            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $imageData = $request->input('image');
            $filename = $request->input('filename', 'profile.jpg');

            if (!$imageData) {
                return response()->json(['success' => false, 'message' => 'No image data provided'], 400);
            }

            // Extract base64 data
            if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $matches)) {
                $extension = $matches[1];
                $imageData = substr($imageData, strpos($imageData, ',') + 1);
            } else {
                $extension = pathinfo($filename, PATHINFO_EXTENSION) ?: 'jpg';
            }

            // Decode base64
            $decodedImage = base64_decode($imageData);

            if ($decodedImage === false) {
                return response()->json(['success' => false, 'message' => 'Invalid image data'], 400);
            }

            // Generate unique filename
            $newFilename = 'customer_profiles/' . $user->id . '_' . time() . '.' . $extension;

            // Store the image
            Storage::disk('public')->put($newFilename, $decodedImage);

            // Update customer details
            $user->customerPersonalDetail()->updateOrCreate(
                ['user_id' => $user->id],
                ['profile_image' => $newFilename]
            );

            return response()->json([
                'success' => true,
                'message' => 'Profile image updated successfully.',
                'image_url' => asset('storage/' . $newFilename)
            ]);

        } catch (\Exception $e) {
            Log::error('Profile image upload error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload image'
            ], 500);
        }
    }

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
        try {
            $user = Auth::guard('customer')->user();

            if (!$user) {
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
                }
                abort(403, 'Unauthorized action.');
            }

            // Handle profile image upload FIRST (simple case)
            if ($request->hasFile('profile_image')) {
                $file = $request->file('profile_image');

                if ($file->isValid()) {
                    $imagePath = $file->store('customer_profiles', 'public');

                    // Update or create customer details with just the image
                    $user->customerPersonalDetail()->updateOrCreate(
                        ['user_id' => $user->id],
                        ['profile_image' => $imagePath]
                    );

                    // If this is ONLY a profile image upload (AJAX), return JSON
                    if ($request->expectsJson() || $request->ajax()) {
                        return response()->json([
                            'success' => true,
                            'message' => 'Profile image updated successfully.',
                            'image_url' => asset('storage/' . $imagePath)
                        ]);
                    }

                    // If there are no other fields, just redirect
                    if (!$request->filled('first_name') && !$request->filled('display_name')) {
                        return redirect()->route('customer.profile')->with('success', 'Profile image updated successfully.');
                    }
                }
            }

            // Handle other form fields
            $existingDetail = $user->customerPersonalDetail;

            // Update user's name if provided
            if ($request->filled('first_name') || $request->filled('last_name')) {
                $firstName = $request->input('first_name', '');
                $lastName = $request->input('last_name', '');
                $user->name = trim($firstName . ' ' . $lastName);
                $user->save();
            }

            // Handle phone number
            $phoneNumber = $existingDetail?->phone_number;
            $phoneVerified = $existingDetail?->phone_verified ?? false;

            if ($request->filled('phone_number')) {
                $phoneNumber = $request->input('phone_number');
                if ($existingDetail && $existingDetail->phone_number === $phoneNumber) {
                    $phoneVerified = $existingDetail->phone_verified;
                } else {
                    $phoneVerified = false;
                }
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

            // Preserve display_name if not present in request
            if (!$request->has('display_name') && $existingDetail) {
                $request->merge(['display_name' => $existingDetail->display_name]);
            }

            // Merge all data
            $requestData = array_merge(
                $request->all(),
                [
                    'user_id' => $user->id,
                    'phone_number' => $phoneNumber,
                    'phone_verified' => $phoneVerified,
                ]
            );

            // Remove profile_image from DTO data (already handled above)
            unset($requestData['profile_image']);

            // Pass data to DTO and action
            $dto = new CustomerPersonalDetailDTO($requestData);
            $action->execute($dto);

            // Return JSON response for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Details saved successfully.',
                ]);
            }

            return redirect()->route('customer.profile')->with('success', 'Details saved successfully.');

        } catch (\Exception $e) {
            Log::error('Profile update error: ' . $e->getMessage() . ' | ' . $e->getTraceAsString());

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'An error occurred while saving your details.');
        }
    }
}
