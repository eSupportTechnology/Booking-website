<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Deal;

class DealsController extends Controller
{
    public function getActiveDeals()
    {
        $limit = request()->get('limit', 10);
        
        $deals = Deal::active()
                    ->with(['property.files', 'property.reviews', 'room', 'dealDates'])
                    ->limit($limit)
                    ->get()
                    ->map(function ($deal) {
                        $propertyImage = '/images/property.png'; // Default fallback
                        if ($deal->property && $deal->property->files->count() > 0) {
                            $firstFile = $deal->property->files->first();
                            $propertyImage = $firstFile->path ? '/storage/' . $firstFile->path : '/images/property.png';
                        }
                        
                        return [
                            'id' => $deal->id,
                            'title' => $deal->title,
                            'description' => $deal->description,
                            'deal_type' => $deal->deal_type,
                            'discount_percentage' => $deal->discount_percentage,
                            'fixed_discount_amount' => $deal->fixed_discount_amount,
                            'special_offer_text' => $deal->special_offer_text,
                            'applicable_to' => $deal->applicable_to,
                            'original_price' => $deal->original_price,
                            'discounted_price' => $deal->discounted_price,
                            'discount_display' => $deal->discount_display,
                            'currency' => $deal->currency ?? 'USD',
                            'start_date' => $deal->start_date,
                            'end_date' => $deal->end_date,
                            'available_dates' => $deal->dealDates->pluck('available_date')->map(fn($date) => $date->format('Y-m-d')),
                            'is_weekend_only' => $deal->dealDates->where('is_weekend', true)->count() === $deal->dealDates->count(),
                            'property' => $deal->property ? [
                                'id' => $deal->property->id,
                                'title' => $deal->property->title,
                                'city' => $deal->property->city,
                                'image' => $propertyImage,
                                'rating' => $deal->property->reviews->avg('rating') ?? 4.5,
                                'reviews_count' => $deal->property->reviews->count()
                            ] : null,
                            'room' => $deal->room ? [
                                'id' => $deal->room->id,
                                'name' => $deal->room->name,
                                'price_per_night' => $deal->room->price_per_night
                            ] : null
                        ];
                    });

        return response()->json($deals);
    }
}