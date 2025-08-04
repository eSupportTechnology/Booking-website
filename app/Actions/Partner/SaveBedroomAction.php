<?php

namespace App\Actions\Partner;

use App\DTOs\Partner\SaveBedroomDTO;
use App\Models\Property;
use App\Models\PropertyBedroom;
use Illuminate\Support\Facades\Log;

class SaveBedroomAction
{
    public function execute(SaveBedroomDTO $dto, Property $property): void
    {
        Log::info('SaveBedroomAction::execute called', [
            'property_id' => $property->id,
            'dto_data' => $dto->toArray()
        ]);

        // Determine room type from the room name
        $roomType = 'bedroom'; // default
        $roomName = strtolower($dto->room_name);
        
        if (str_contains($roomName, 'living') || str_contains($roomName, 'lounge')) {
            $roomType = 'living_room';
        } elseif (str_contains($roomName, 'bedroom')) {
            $roomType = 'bedroom';
        } else {
            $roomType = 'other';
        }

        // Create room data with bed counts
        // Use proper display name for consistency
        $displayName = $dto->room_name;
        if ($dto->room_name === 'livingRoom') {
            $displayName = 'Living room';
        } elseif ($dto->room_name === 'otherSpaces') {
            $displayName = 'Other spaces';
        }
        
        $roomData = [
            'property_id' => $property->id,
            'room_type' => $roomType,
            'name' => $displayName,
            'twin' => 0,
            'full' => 0,
            'queen' => 0,
            'king' => 0,
            'bunk' => 0,
            'sofa' => 0,
            'futon' => 0,
        ];

        // Map bed types to columns
        foreach ($dto->beds as $bed) {
            $bedName = strtolower($bed['name']);
            switch ($bedName) {
                case 'twin':
                case 'twin bed':
                    $roomData['twin'] = $bed['count'];
                    break;
                case 'full':
                case 'full bed':
                    $roomData['full'] = $bed['count'];
                    break;
                case 'queen':
                case 'queen bed':
                    $roomData['queen'] = $bed['count'];
                    break;
                case 'king':
                case 'king bed':
                    $roomData['king'] = $bed['count'];
                    break;
                case 'bunk':
                case 'bunk bed':
                    $roomData['bunk'] = $bed['count'];
                    break;
                case 'sofa':
                case 'sofa bed':
                    $roomData['sofa'] = $bed['count'];
                    break;
                case 'futon':
                case 'futon bed':
                    $roomData['futon'] = $bed['count'];
                    break;
            }
        }

        // Check if this is an existing room or a new one
        // Handle different naming conventions
        $roomNameVariations = [
            $dto->room_name, // Original name
            strtolower($dto->room_name), // Lowercase
            ucfirst(strtolower($dto->room_name)), // First letter uppercase
            str_replace('_', ' ', $dto->room_name), // Replace underscores with spaces
            str_replace('_', ' ', ucwords(strtolower($dto->room_name))), // Proper case with spaces
        ];
        
        // Add specific variations for known room types
        if ($dto->room_name === 'livingRoom') {
            $roomNameVariations[] = 'Living room';
            $roomNameVariations[] = 'Living Room';
            $roomNameVariations[] = 'living room';
            $roomNameVariations[] = 'livingRoom';
            $roomNameVariations[] = 'livingroom';
            $roomNameVariations[] = 'LivingRoom';
        } elseif ($dto->room_name === 'otherSpaces') {
            $roomNameVariations[] = 'Other spaces';
            $roomNameVariations[] = 'Other Spaces';
            $roomNameVariations[] = 'Other Space';
            $roomNameVariations[] = 'other spaces';
            $roomNameVariations[] = 'otherSpaces';
            $roomNameVariations[] = 'otherspaces';
            $roomNameVariations[] = 'OtherSpaces';
        }
        
        // Also check by room type for living room and other spaces
        $roomType = null;
        if ($dto->room_name === 'livingRoom') {
            $roomType = 'living_room';
        } elseif ($dto->room_name === 'otherSpaces') {
            $roomType = 'other';
        }
        
        $existingRoom = null;
        
        // First try to find by room type (this is the most reliable method)
        if ($roomType) {
            $existingRoom = PropertyBedroom::where('property_id', $property->id)
                ->where('room_type', $roomType)
                ->first();
            Log::info('Looking for existing room by room_type', [
                'property_id' => $property->id,
                'room_type' => $roomType,
                'found' => $existingRoom ? $existingRoom->name : 'not found'
            ]);
        }
        
        // If not found by room type, try by name variations
        if (!$existingRoom) {
            $existingRoom = PropertyBedroom::where('property_id', $property->id)
                ->whereIn('name', $roomNameVariations)
                ->first();
            Log::info('Looking for existing room by name variations', [
                'property_id' => $property->id,
                'name_variations' => $roomNameVariations,
                'found' => $existingRoom ? $existingRoom->name : 'not found'
            ]);
        }
        
        // If still not found, try a more flexible search by room type and any name that contains the key words
        if (!$existingRoom && $roomType) {
            if ($roomType === 'living_room') {
                $existingRoom = PropertyBedroom::where('property_id', $property->id)
                    ->where('room_type', $roomType)
                    ->where(function($query) {
                        $query->where('name', 'like', '%living%')
                              ->orWhere('name', 'like', '%lounge%');
                    })
                    ->first();
            } elseif ($roomType === 'other') {
                $existingRoom = PropertyBedroom::where('property_id', $property->id)
                    ->where('room_type', $roomType)
                    ->where('name', 'like', '%other%')
                    ->first();
            }
            
            if ($existingRoom) {
                Log::info('Found existing room by flexible search', [
                    'property_id' => $property->id,
                    'room_type' => $roomType,
                    'found' => $existingRoom->name
                ]);
            }
        }

        if ($existingRoom) {
            // Update existing room
            $existingRoom->update($roomData);
            $room = $existingRoom;
            Log::info('Updated existing room', [
                'room_id' => $room->id,
                'room_name' => $room->name,
                'room_type' => $room->room_type,
                'sofa_count' => $room->sofa,
                'full_count' => $room->full,
                'queen_count' => $room->queen
            ]);
        } else {
            // Log all existing rooms for this property to debug
            $allExistingRooms = PropertyBedroom::where('property_id', $property->id)->get();
            Log::info('No existing room found. All rooms for this property:', [
                'property_id' => $property->id,
                'room_name' => $dto->room_name,
                'room_type' => $roomType,
                'all_existing_rooms' => $allExistingRooms->map(function($r) {
                    return [
                        'id' => $r->id,
                        'name' => $r->name,
                        'room_type' => $r->room_type
                    ];
                })->toArray()
            ]);
            
            // Create new room
            $room = PropertyBedroom::create($roomData);
            Log::info('Created new room', [
                'room_id' => $room->id,
                'room_name' => $room->name,
                'room_type' => $room->room_type,
                'sofa_count' => $room->sofa,
                'full_count' => $room->full,
                'queen_count' => $room->queen
            ]);
        }

        Log::info('Room saved successfully', [
            'property_id' => $property->id,
            'room_id' => $room->id,
            'room_type' => $roomType,
            'room_data' => $roomData
        ]);
    }
} 