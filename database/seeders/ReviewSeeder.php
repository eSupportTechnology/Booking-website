<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Property;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $properties = Property::all();
        $users = User::all();

        if ($properties->count() > 0 && $users->count() > 0) {
            $sampleReviews = [
                [
                    'rating' => 9.2,
                    'comment' => 'Really comfortable bed, and big spa bath. Enjoyed the pool table as was heavy rain outside, and the Sri Lankan breakfast was delicious!',
                    'staff_rating' => 9.5,
                    'facilities_rating' => 9.8,
                    'cleanliness_rating' => 9.3,
                    'comfort_rating' => 9.6,
                    'value_rating' => 8.8,
                    'location_rating' => 9.1,
                    'wifi_rating' => 9.0,
                ],
                [
                    'rating' => 8.8,
                    'comment' => 'The Hospitality is the best and out of the world. Very homely feeling and Room comfort was outstanding. Highly recommended! Must stay property.',
                    'staff_rating' => 9.0,
                    'facilities_rating' => 9.5,
                    'cleanliness_rating' => 9.2,
                    'comfort_rating' => 9.4,
                    'value_rating' => 8.5,
                    'location_rating' => 8.9,
                    'wifi_rating' => 8.8,
                ],
                [
                    'rating' => 8.5,
                    'comment' => 'Great location and friendly staff. The room was clean and comfortable. Would definitely stay here again!',
                    'staff_rating' => 8.8,
                    'facilities_rating' => 9.0,
                    'cleanliness_rating' => 9.1,
                    'comfort_rating' => 8.9,
                    'value_rating' => 8.7,
                    'location_rating' => 9.3,
                    'wifi_rating' => 9.2,
                ]
            ];

            foreach ($properties->take(3) as $property) {
                foreach ($sampleReviews as $reviewData) {
                    Review::create([
                        'property_id' => $property->id,
                        'user_id' => $users->random()->id,
                        'booking_id' => 1,
                        'rating' => $reviewData['rating'],
                        'comment' => $reviewData['comment'],
                        'staff_rating' => $reviewData['staff_rating'],
                        'facilities_rating' => $reviewData['facilities_rating'],
                        'cleanliness_rating' => $reviewData['cleanliness_rating'],
                        'comfort_rating' => $reviewData['comfort_rating'],
                        'value_rating' => $reviewData['value_rating'],
                        'location_rating' => $reviewData['location_rating'],
                        'wifi_rating' => $reviewData['wifi_rating'],
                    ]);
                }
            }
        }
    }
}