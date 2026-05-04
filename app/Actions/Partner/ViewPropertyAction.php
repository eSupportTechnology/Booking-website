<?php

namespace App\Actions\Partner;

use App\Models\Property;
use App\Models\Review;
use App\Models\HostReview;
use Illuminate\Support\Facades\DB;

class ViewPropertyAction
{
    public function execute(int $id): array
    {
        // Load basic property first
        $property = Property::find($id);
        
        if (!$property) {
            return ['property' => null];
        }
        
        // Try to load each relationship individually with error handling
        $relationships = [
            'amenities',
            'additionalDetails', 
            'policies',
            'services',
            'languages',
            'hostProfile',
            'pricing',
            'facilities',
            'bedrooms',
            'files'
        ];
        
        foreach ($relationships as $relationship) {
            try {
                $property->load($relationship);
            } catch (\Exception $e) {
                // Relationship table doesn't exist, continue without it
            }
        }

        // Get reviews data
        $reviews = Review::where('property_id', $id)
            ->with(['user', 'traveler'])
            ->latest()
            ->limit(3)
            ->get();

        $totalReviews = Review::where('property_id', $id)->count();
        
        $overallRating = $totalReviews > 0 ? (float) Review::where('property_id', $id)->avg('rating') : null;
        $staffRating = $totalReviews > 0 ? (float) (Review::where('property_id', $id)->avg('staff_rating') ?? $overallRating) : null;
        $facilitiesRating = $totalReviews > 0 ? (float) (Review::where('property_id', $id)->avg('facilities_rating') ?? $overallRating) : null;
        $cleanlinessRating = $totalReviews > 0 ? (float) (Review::where('property_id', $id)->avg('cleanliness_rating') ?? $overallRating) : null;
        $comfortRating = $totalReviews > 0 ? (float) (Review::where('property_id', $id)->avg('comfort_rating') ?? $overallRating) : null;
        $valueRating = $totalReviews > 0 ? (float) (Review::where('property_id', $id)->avg('value_rating') ?? $overallRating) : null;
        $locationRating = $totalReviews > 0 ? (float) (Review::where('property_id', $id)->avg('location_rating') ?? $overallRating) : null;
        $wifiRating = $totalReviews > 0 ? (float) (Review::where('property_id', $id)->avg('wifi_rating') ?? $overallRating) : null;

        $ratingText = $totalReviews > 0 ? $this->getRatingText($overallRating) : null;

        $totalHostReviews = HostReview::where('property_id', $id)->count();
        $hostAvgRating = $totalHostReviews > 0 ? (float) HostReview::where('property_id', $id)->avg('rating') : null;

        $format = fn ($v) => $v === null ? null : number_format($v, 1);

        return [
            'property' => $property,
            'reviews' => $reviews,
            'totalReviews' => $totalReviews,
            'overallRating' => $format($overallRating),
            'ratingText' => $ratingText,
            'staffRating' => $format($staffRating),
            'facilitiesRating' => $format($facilitiesRating),
            'cleanlinessRating' => $format($cleanlinessRating),
            'comfortRating' => $format($comfortRating),
            'valueRating' => $format($valueRating),
            'locationRating' => $format($locationRating),
            'wifiRating' => $format($wifiRating),
            'hostAvgRating' => $format($hostAvgRating),
        ];
    }
    
    private function getRatingText(float $rating): string
    {
        if ($rating >= 9.0) return 'Superb';
        if ($rating >= 8.0) return 'Very good';
        if ($rating >= 7.0) return 'Good';
        if ($rating >= 6.0) return 'Pleasant';
        return 'Fair';
    }
}