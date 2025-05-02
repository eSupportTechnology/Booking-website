<?php

namespace App\Http\Controllers;

use App\Models\TravelersDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TravelerDetailsController extends Controller
{
    public function showTravelerDetails()
    {
        $traveler = Auth::guard('traveler')->user();

        $details = TravelersDetails::where('traveler_id', $traveler->id)->first();

        return view('traveler.profile', compact('traveler', 'details'));
    }

    public function updateTravelerDetails(Request $request)
{
    $traveler = Auth::guard('traveler')->user();

    $request->validate([
        'name' => 'nullable|string|max:255',
        'display_name' => 'nullable|string|max:255',
        'email' => 'nullable|email|unique:travelers,email,' . $traveler->id,
        'phone' => 'nullable|string|max:20',
        'dob' => 'nullable|date',
        'nationality' => 'nullable|string|max:255',
        'gender' => 'nullable|string|max:10',
        'passport_details' => 'nullable|string|max:255',
        'address' => 'nullable|string',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Update travelers table
    $traveler->name = $request->input('name');
    $traveler->email = $request->input('email');
    $traveler->save();

    // Update or create traveler details
    $detail = TravelersDetails::firstOrNew(['traveler_id' => $traveler->id]);

    if ($request->hasFile('profile_picture')) {
        $filename = time() . '_' . $request->file('profile_picture')->getClientOriginalName();
        $path = $request->file('profile_picture')->storeAs('profile_pictures', $filename, 'public');
        $detail->profile_picture = $path;
    }

    $detail->fill($request->except(['profile_picture', 'name', 'email']));
    $detail->traveler_id = $traveler->id;
    $detail->save();

    return redirect()->route('traveler.profile')->with('success', 'Traveler details updated successfully.');
}

}
