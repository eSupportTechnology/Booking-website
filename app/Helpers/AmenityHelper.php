<?php

namespace App\Helpers;

class AmenityHelper
{
    public static function getAmenityIconMapping()
    {
        return [
            'Private bathroom' => 'Private_bathroom.svg',
            'Sea views' => 'Sea_view.svg',
            'Family rooms' => 'Family_rooms.svg',
            'Airport shuttle' => 'Airport_shuttle.svg',
            'Spa and wellness center' => 'Spa_and_wellness_centre.svg',
            'Air conditioning' => 'Air_conditioning.svg',
            'Heating' => 'Heating.svg',
            'Free WiFi' => 'In_all_areas_78_Mbps.svg',
            'Kitchen' => 'Kitchen.svg',
            'Kitchenette' => 'Kitchen.svg',
            'Washing machine' => 'Washing_machine.svg',
            'Flat-screen TV' => 'Flat-screen_TV.svg',
            'Balcony' => 'Balcony.svg',
            'View' => 'View.svg',
            'Bath' => 'Bath.svg',
            'Apartments' => 'Apartments.svg',
            'Pets allowed' => 'Pets_allowed.svg',
            'Non-smoking rooms' => 'Non-smoking_rooms.svg',
            'Free on-site parking' => 'Free_on-site_parking.svg',
            'Private parking' => 'Private_parking.svg',
            'Very good breakfast' => 'Very_good_breakfast.svg',
            'Private pool' => '2_swimming_pools.svg',
            '4 restaurants' => '4_restaurants.svg',
            '64 m size' => '64_m_size.svg',
            'Swimming Pool' => 'Swimming_Pool.svg',
            'Hot tub' => 'Hot_tub.svg',
            'Minibar' => 'Minibar.svg',
            'Sauna' => 'Sauna.svg',
            'Garden view' => 'Garden_view.svg',
            'Terrace' => 'Terrace.svg',
        ];
    }

    public static function getAmenityIcon($amenityName)
    {
        $mapping = self::getAmenityIconMapping();
        return $mapping[$amenityName] ?? null;
    }
}