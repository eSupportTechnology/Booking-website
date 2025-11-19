<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\PropertySubcategory;
use App\Models\PropertySubtype;
use App\Models\Amenity;
use App\Models\File;
use App\Models\PropertyAdditionalDetail;
use App\Models\Languages;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\BedType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PropertyCreationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function start($propertyId = null)
    {
        $categories = PropertyCategory::all();
        $mode = $propertyId ? 'edit' : 'create';
        $property = $propertyId ? Property::find($propertyId) : null;

        if ($propertyId) {
            session(['property_creation_id' => $propertyId]);
        }

        return view('property.create.step1-type', compact('categories', 'mode', 'property'));
    }

    public function getSubcategories($categoryId)
    {
        $subcategories = PropertySubcategory::where('category_id', $categoryId)->get();
        return response()->json($subcategories);
    }

    public function getSubtypes($subcategoryId)
    {
        $subtypes = PropertySubtype::where('subcategory_id', $subcategoryId)->get();
        return response()->json($subtypes);
    }

    public function saveStep(Request $request, $step, $propertyId = null)
    {
        if ($propertyId) {
            session(['property_creation_id' => $propertyId]);
        }

        $propertyId = session('property_creation_id');

        switch ($step) {
            case 1:
                return $this->saveStep1($request, $propertyId);
            case 2:
                return $this->saveStep2($request, $propertyId);
            case 3:
                return $this->saveStep3($request, $propertyId);
            case '3.5':
            case '3_5':
            case 3.5:
                return $this->saveStep3_5($request, $propertyId);
            case 4:
                return $this->saveStep4($request, $propertyId);
            case 5:
                return $this->saveStep5($request, $propertyId);
            case 6:
                return $this->saveStep6($request, $propertyId);
            case 7:
                return $this->saveStep7($request, $propertyId);
        }
    }

    private function saveStep1(Request $request, $propertyId = null)
    {
        try {
            $request->validate([
                'category_id' => 'required|exists:property_categories,id'
            ]);

            // Check if we're editing an existing property
            if (!$propertyId) {
                $propertyId = session('property_creation_id');
            }

            if ($propertyId) {
                // Update existing property
                $property = Property::find($propertyId);
                if (!$property) {
                    return response()->json(['success' => false, 'message' => 'Property not found'], 422);
                }

                $property->update([
                    'category_id' => $request->category_id,
                    'subcategory_id' => $request->subcategory_id ?? null,
                    'subtype_id' => $request->subtype_id ?? null,
                    'current_step' => max($property->current_step, 1)
                ]);

                session(['property_creation_id' => $property->id]);
            } else {
                // Create new property
                $userId = Auth::id() ?? 1;

                $property = Property::create([
                    'user_id' => $userId,
                    'category_id' => $request->category_id,
                    'subcategory_id' => $request->subcategory_id ?? null,
                    'subtype_id' => $request->subtype_id ?? null,
                    'address_type_id' => null,
                    'title' => 'Untitled Property',
                    'description' => 'Property description will be added later',
                    'address' => 'Address will be added later',
                    'city' => 'City will be added later',
                    'country' => 'Country will be added later',
                    'current_step' => 1,
                    'status' => 'pending'
                ]);

                session(['property_creation_id' => $property->id]);
            }

            return response()->json(['success' => true, 'next_step' => 2]);
        } catch (\Exception $e) {
            Log::error('Property creation error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    private function saveStep2(Request $request, $propertyId)
    {
        if (!$propertyId) {
            return response()->json(['success' => false, 'message' => 'Property ID not found'], 422);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string'
        ]);

        $property = Property::find($propertyId);
        if (!$property) {
            return response()->json(['success' => false, 'message' => 'Property not found'], 422);
        }

        $property->update([
            'title' => $request->title,
            'description' => $request->description,
            'address' => $request->address,
            'apartment' => $request->apartment,
            'city' => $request->city,
            'country' => $request->country,
            'current_step' => max($property->current_step, 2)
        ]);

        return response()->json(['success' => true, 'next_step' => 3]);
    }

    private function saveStep3(Request $request, $propertyId)
    {
        try {
            $request->validate([
                'guests' => 'required|integer|min:1',
                'bedrooms' => 'required|integer|min:1',
                'bathrooms' => 'required|integer|min:1',
                'amenities' => 'array',
                'breakfast' => 'boolean',
                'breakfast_price' => 'nullable|numeric|min:0',
                'parking' => 'boolean',
                'wifi' => 'boolean',
                'pets_allowed' => 'boolean'
            ]);

            DB::transaction(function () use ($request, $propertyId) {
                $property = Property::find($propertyId);

                // Save additional details
                PropertyAdditionalDetail::updateOrCreate(
                    ['property_id' => $propertyId],
                    [
                        'guests' => $request->guests,
                        'bedrooms' => $request->bedrooms,
                        'bathrooms' => $request->bathrooms
                    ]
                );

                // Save amenities
                if ($request->amenities) {
                    $property->amenities()->sync($request->amenities);
                } else {
                    $property->amenities()->detach();
                }

                // Save services using existing table structure
                DB::table('property_services')->updateOrInsert(
                    ['property_id' => $propertyId],
                    [
                        'serve_breakfast' => $request->boolean('breakfast'),
                        'breakfast_price' => $request->breakfast_price,
                        'parking_available' => $request->boolean('parking') ? 'yes' : 'no',
                        'updated_at' => now()
                    ]
                );

                $property->update(['current_step' => max($property->current_step, 3)]);
            });

            return response()->json(['success' => true, 'next_step' => 4]);
        } catch (\Exception $e) {
            Log::error('Step 3 save error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    private function saveStep3_5(Request $request, $propertyId)
    {
        try {
            if (!$propertyId) {
                return response()->json(['success' => false, 'message' => 'Property ID not found'], 422);
            }

            // Check if this is a room creation, bathroom update, or amenities update
            if ($request->has('room_type_id')) {
                // Step 1: Create rooms
                $request->validate([
                    'room_type_id' => 'required|exists:room_types,id',
                    'room_count' => 'required|integer|min:1',
                    'max_guests' => 'required|integer|min:1',
                    'size_sq_m' => 'required|numeric|min:1',
                    'smoking_allowed' => 'boolean',
                    'beds' => 'array'
                ]);

                $createdRooms = [];
                for ($i = 0; $i < $request->room_count; $i++) {
                    $roomType = RoomType::find($request->room_type_id);
                    $room = Room::create([
                        'property_id' => $propertyId,
                        'room_type_id' => $request->room_type_id,
                        'max_guests' => $request->max_guests,
                        'size_sq_m' => $request->size_sq_m,
                        'smoking_allowed' => $request->boolean('smoking_allowed'),
                        'name' => ($roomType ? $roomType->name : 'Room') . ' ' . ($i + 1),
                        'price_per_night' => 0.00, // Default price, can be updated later in pricing step
                        'bathroom_count' => 1 // Default bathroom count, can be updated in bathroom step
                    ]);

                    // Attach beds
                    if ($request->beds) {
                        foreach ($request->beds as $bed) {
                            $bedType = BedType::where('name', $bed['type'])->first();
                            if ($bedType && $bed['count'] > 0) {
                                $room->beds()->attach($bedType->id, ['count' => $bed['count']]);
                            }
                        }
                    }

                    $createdRooms[] = ['id' => $room->id, 'name' => $room->name];
                }

                return response()->json([
                    'success' => true,
                    'rooms' => $createdRooms
                ]);
            } elseif ($request->has('rooms')) {
                // Step 2: Update bathroom details
                if ($request->has('bathroom_type')) {
                    $request->validate([
                        'rooms' => 'required|array',
                        'bathroom_type' => 'required|in:private,shared',
                        'bathroom_amenities' => 'array'
                    ]);

                    // Get room IDs - handle both array of IDs and array of objects
                    $roomIds = [];
                    foreach ($request->rooms as $roomItem) {
                        if (is_array($roomItem)) {
                            $roomIds[] = $roomItem['id'] ?? $roomItem;
                        } else {
                            $roomIds[] = $roomItem;
                        }
                    }

                    // Find all rooms at once and filter by property_id
                    $rooms = Room::whereIn('id', $roomIds)
                        ->where('property_id', $propertyId)
                        ->get();

                    foreach ($rooms as $room) {
                        $room->update([
                            'bathroom_type' => $request->bathroom_type,
                            'bathroom_amenities' => json_encode($request->bathroom_amenities ?? [])
                        ]);
                    }

                    return response()->json(['success' => true]);
                } else {
                    // Step 3: Update room amenities
                    $request->validate([
                        'rooms' => 'required|array',
                        'amenities' => 'array'
                    ]);

                    // Get room IDs - handle both array of IDs and array of objects
                    $roomIds = [];
                    foreach ($request->rooms as $roomItem) {
                        if (is_array($roomItem)) {
                            $roomIds[] = $roomItem['id'] ?? $roomItem;
                        } else {
                            $roomIds[] = $roomItem;
                        }
                    }

                    // Find all rooms at once and filter by property_id
                    $rooms = Room::whereIn('id', $roomIds)
                        ->where('property_id', $propertyId)
                        ->get();

                    foreach ($rooms as $room) {
                        $room->amenities()->sync($request->amenities ?? []);
                    }

                    return response()->json(['success' => true]);
                }
            }

            return response()->json(['success' => false, 'message' => 'Invalid request'], 422);
        } catch (\Exception $e) {
            Log::error('Step 3.5 save error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    private function saveStep4(Request $request, $propertyId)
    {
        try {
            $request->validate([
                'host_name' => 'required|string|max:255',
                'languages' => 'array'
            ]);

            DB::transaction(function () use ($request, $propertyId) {
                $property = Property::find($propertyId);

                // Save host profile using existing table structure
                DB::table('property_host_profiles')->updateOrInsert(
                    ['property_id' => $propertyId],
                    [
                        'host_name' => $request->host_name,
                        'about_host' => $request->about,
                        'updated_at' => now()
                    ]
                );

                // Save languages using existing table structure
                if ($request->languages) {
                    DB::table('property_language')->where('property_id', $propertyId)->delete();
                    foreach ($request->languages as $languageId) {
                        DB::table('property_language')->insert([
                            'property_id' => $propertyId,
                            'language_id' => $languageId,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }

                $property->update(['current_step' => max($property->current_step, 4)]);
            });

            return response()->json(['success' => true, 'next_step' => 5]);
        } catch (\Exception $e) {
            Log::error('Step 4 save error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    private function saveStep5(Request $request, $propertyId)
    {
        Log::info('Step 5 saveStep5 called', [
            'propertyId' => $propertyId,
            'hasFiles' => $request->hasFile('photos'),
            'filesCount' => $request->hasFile('photos') ? count($request->file('photos')) : 0
        ]);

        try {
            if (!$propertyId) {
                Log::error('Property ID not found in saveStep5');
                return response()->json(['success' => false, 'message' => 'Property ID not found'], 422);
            }

            // Only validate if photos are being uploaded
            if ($request->hasFile('photos')) {
                Log::info('Validating photos');
                $request->validate([
                    'photos' => 'array',
                    'photos.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120' // 5MB = 5120 KB
                ]);

                Log::info('Photos validated, starting upload');
                foreach ($request->file('photos') as $index => $photo) {
                    Log::info('Uploading photo', ['index' => $index, 'name' => $photo->getClientOriginalName()]);
                    $path = $photo->store('properties', 'public');
                    Log::info('Photo stored', ['path' => $path]);

                    $file = File::create([
                        'property_id' => $propertyId,
                        'path' => $path,
                        'file_type' => 'image'
                    ]);
                    Log::info('File record created', ['file_id' => $file->id]);
                }
            }

            // Check total photos (existing + new)
            $totalPhotos = File::where('property_id', $propertyId)->where('file_type', 'image')->count();
            Log::info('Total photos count', ['count' => $totalPhotos]);

            if ($totalPhotos < 3) {
                Log::warning('Not enough photos uploaded', ['count' => $totalPhotos]);
                return response()->json(['success' => false, 'message' => 'Please upload at least 3 photos total'], 422);
            }

            $property = Property::find($propertyId);
            $property->update(['current_step' => max($property->current_step, 5)]);
            Log::info('Step 5 completed successfully');

            return response()->json(['success' => true, 'next_step' => 6]);
        } catch (\Exception $e) {
            Log::error('Photo upload error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['success' => false, 'message' => 'Photo upload failed: ' . $e->getMessage()], 422);
        }
    }

    private function saveStep6(Request $request, $propertyId)
    {
        $request->validate([
            'adult_price' => 'required|numeric|min:0',
            'children_price' => 'required|numeric|min:0'
        ]);

        // Get commission rate from admin settings or use default
        $commissionRate = config('app.default_commission_rate', 15);

        $property = Property::find($propertyId);
        $property->update([
            'adult_price' => $request->adult_price,
            'children_price' => $request->children_price,
            'commission_rate' => $commissionRate,
            'current_step' => max($property->current_step, 6)
        ]);

        return response()->json(['success' => true, 'next_step' => 7]);
    }

    private function saveStep7(Request $request, $propertyId)
    {
        $property = Property::find($propertyId);
        $property->update([
            'status' => 'active',
            'current_step' => max($property->current_step, 7)
        ]);

        session()->forget('property_creation_id');
        session()->flash('success', 'Property created successfully! Your property is now live and ready for bookings.');

        return response()->json([
            'success' => true,
            'completed' => true,
            'redirect' => route('partner.properties.apartments')
        ]);
    }

    public function deletePhoto($id)
    {
        $file = File::find($id);
        if ($file) {
            Storage::disk('public')->delete($file->path);
            $file->delete();
        }
        return response()->json(['success' => true]);
    }

    public function showStep($step, $propertyId = null)
    {
        if ($propertyId) {
            session(['property_creation_id' => $propertyId]);
        }

        $propertyId = session('property_creation_id');
        $property = $propertyId ? Property::with(['additionalDetails', 'amenities', 'files'])->find($propertyId) : null;
        $mode = $propertyId && $property ? 'edit' : 'create';

        switch ($step) {
            case 2:
                return view('property.create.step2-basic', compact('property', 'mode'));
            case 3:
                $amenities = Amenity::all()->groupBy('category');
                $selectedAmenities = $property ? $property->amenities->pluck('id')->toArray() : [];
                $services = $property ? DB::table('property_services')->where('property_id', $property->id)->first() : null;
                return view('property.create.step3-details', compact('property', 'amenities', 'selectedAmenities', 'services', 'mode'));
            case '3.5':
            case '3_5':
            case 3.5:
                $roomTypes = RoomType::all();
                $bedTypes = BedType::all();
                $groupedAmenities = Amenity::all()->groupBy('category');
                $existingRooms = $property ? Room::where('property_id', $property->id)->get() : collect();
                return view('property.create.step3-rooms', compact('property', 'roomTypes', 'bedTypes', 'groupedAmenities', 'existingRooms', 'mode'));
            case 4:
                $languages = Languages::all();
                $hostProfile = $property ? DB::table('property_host_profiles')->where('property_id', $property->id)->first() : null;
                $selectedLanguages = $property ? DB::table('property_language')->where('property_id', $property->id)->pluck('language_id')->toArray() : [];
                return view('property.create.step4-host', compact('property', 'languages', 'hostProfile', 'selectedLanguages', 'mode'));
            case 5:
                $existingPhotos = $property ? File::where('property_id', $property->id)->where('file_type', 'image')->get() : collect();
                return view('property.create.step5-photos', compact('property', 'existingPhotos', 'mode'));
            case 6:
                return view('property.create.step6-pricing', compact('property', 'mode'));
            case 7:
                $property = $propertyId ? Property::with(['additionalDetails', 'amenities', 'files', 'hostProfile'])->find($propertyId) : null;
                return view('property.create.step7-review', compact('property', 'mode'));
            default:
                return redirect()->route('property.create');
        }
    }
}
