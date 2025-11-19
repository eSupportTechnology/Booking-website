<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyDashboardController extends Controller
{
    public function dashboard()
    {
        $properties = Property::where('user_id', auth()->id())
            ->with(['photos', 'bookings', 'reviews', 'amenities', 'policies'])
            ->get()
            ->map(function ($property) {
                return [
                    'id' => $property->id,
                    'title' => $property->title ?: 'Untitled Property',
                    'status' => $property->status ?: 'draft',
                    'completion' => $this->calculateCompletion($property),
                    'total_bookings' => $property->bookings->count(),
                    'avg_rating' => round($property->reviews->avg('rating') ?: 0, 1),
                    'total_earnings' => $property->bookings->sum('total_amount') ?: 0,
                    'adult_price' => $property->adult_price ?: 0,
                    'child_price' => $property->child_price ?: 0,
                    'commission_rate' => $property->commission_rate ?: 0,
                    'total_price' => $property->total_price_with_commission ?: 0,
                    'photo_count' => $property->photos->count(),
                    'created_at' => $property->created_at->format('M d, Y'),
                    'category' => $property->category->name ?? 'Unknown',
                ];
            });

        $stats = [
            'total_properties' => $properties->count(),
            'active_properties' => $properties->where('status', 'active')->count(),
            'draft_properties' => $properties->where('status', 'draft')->count(),
            'total_bookings' => $properties->sum('total_bookings'),
            'total_earnings' => $properties->sum('total_earnings'),
            'avg_completion' => $properties->avg('completion'),
        ];

        return view('partner.dashboard.properties', compact('properties', 'stats'));
    }

    private function calculateCompletion($property): int
    {
        $steps = [
            'basic_info' => !empty($property->title) && !empty($property->description),
            'location' => !empty($property->address) && !empty($property->city),
            'photos' => $property->photos->count() >= 3,
            'pricing' => !empty($property->adult_price),
            'amenities' => $property->amenities->count() > 0,
            'policies' => $property->policies()->exists(),
        ];

        $completed = array_sum($steps);
        $total = count($steps);

        return (int) ($completed / $total * 100);
    }

    public function updateStatus(Request $request, $propertyId)
    {
        $property = Property::where('id', $propertyId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $request->validate([
            'status' => 'required|in:draft,active,inactive,pending'
        ]);

        $property->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Property status updated successfully'
        ]);
    }

    public function getPropertyStats($propertyId)
    {
        $property = Property::where('id', $propertyId)
            ->where('user_id', auth()->id())
            ->with(['bookings', 'reviews'])
            ->firstOrFail();

        $stats = [
            'views' => rand(50, 500), // Placeholder - implement actual view tracking
            'bookings' => $property->bookings->count(),
            'revenue' => $property->bookings->sum('total_amount'),
            'avg_rating' => round($property->reviews->avg('rating') ?: 0, 1),
            'completion' => $this->calculateCompletion($property),
        ];

        return response()->json($stats);
    }
}