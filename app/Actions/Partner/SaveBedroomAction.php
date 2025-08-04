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
        $roomData = [
            'property_id' => $property->id,
            'room_type' => $roomType,
            'name' => $dto->room_name,
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
        $existingRoom = PropertyBedroom::where('property_id', $property->id)
            ->where('name', $dto->room_name)
            ->first();

        if ($existingRoom) {
            // Update existing room
            $existingRoom->update($roomData);
            $room = $existingRoom;
            Log::info('Updated existing room', [
                'room_id' => $room->id,
                'room_name' => $room->name
            ]);
        } else {
            // Create new room
            $room = PropertyBedroom::create($roomData);
            Log::info('Created new room', [
                'room_id' => $room->id,
                'room_name' => $room->name
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