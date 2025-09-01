<?php

namespace App\Services\Partner;

use App\DTOs\Partner\PropertyStatsDTO;
use App\Models\Property;
use App\Models\Booking;
use App\Models\PropertyCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PropertyService
{
    public function getPropertyStats(): PropertyStatsDTO
    {
        $partnerId = Auth::id();
        
        $totalProperties = Property::where('user_id', $partnerId)->count();
        $activeProperties = Property::where('user_id', $partnerId)->where('status', 'active')->count();
        $pendingApproval = Property::where('user_id', $partnerId)->where('status', 'pending')->count();
        $inactiveProperties = Property::where('user_id', $partnerId)->where('status', 'inactive')->count();
        
        return PropertyStatsDTO::fromArray([
            'total_properties' => $totalProperties,
            'active_properties' => $activeProperties,
            'pending_approval' => $pendingApproval,
            'inactive_properties' => $inactiveProperties
        ]);
    }

    public function getProperties(): array
    {
        $partnerId = Auth::id();
        
        return Property::with(['photos', 'reviews'])
            ->where('user_id', $partnerId)
            ->get()
            ->map(function($property) {
                $bookingsCount = Booking::where('property_id', $property->id)->count();
                
                return [
                    'id' => $property->id,
                    'name' => $property->title ?? 'Untitled Property',
                    'type' => $this->getPropertyType($property->category_id),
                    'location' => $property->city ?? 'Unknown',
                    'status' => ucfirst($property->status ?? 'pending'),
                    'bookings' => $bookingsCount,
                    'image' => $property->photos->first()?->file_path ?? '/images/property-placeholder.jpg'
                ];
            })->toArray();
    }

    public function getPropertiesByType(string $type): array
    {
        $partnerId = Auth::id();
        $categoryId = $this->getCategoryIdByType($type);
        
        $query = Property::with(['photos', 'reviews'])
            ->where('user_id', $partnerId);
            
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        
        return $query->get()
            ->map(function($property) {
                $bookingsCount = Booking::where('property_id', $property->id)->count();
                
                return [
                    'id' => $property->id,
                    'name' => $property->title ?? 'Untitled Property',
                    'type' => $this->getPropertyType($property->category_id),
                    'location' => $property->city ?? 'Unknown',
                    'status' => ucfirst($property->status ?? 'pending'),
                    'bookings' => $bookingsCount,
                    'image' => $property->photos->first()?->file_path ?? '/images/property-placeholder.jpg'
                ];
            })->toArray();
    }

    public function getBookings(): array
    {
        $partnerId = Auth::id();
        
        return Booking::with(['user', 'property'])
            ->whereHas('property', function($query) use ($partnerId) {
                $query->where('user_id', $partnerId);
            })
            ->latest()
            ->get()
            ->map(function($booking) {
                return [
                    'id' => 'BK' . $booking->id,
                    'guest' => $booking->user->name ?? 'Guest',
                    'property' => $booking->property->title ?? 'Property',
                    'check_in' => $booking->check_in?->format('Y-m-d') ?? 'TBD',
                    'check_out' => $booking->check_out?->format('Y-m-d') ?? 'TBD',
                    'status' => ucfirst($booking->status ?? 'pending'),
                    'amount' => $booking->total_price ?? 0,
                    'guest_count' => $booking->guest_count ?? 1
                ];
            })->toArray();
    }

    public function getBookingStats(): array
    {
        $partnerId = Auth::id();
        
        $totalBookings = Booking::whereHas('property', function($query) use ($partnerId) {
            $query->where('user_id', $partnerId);
        })->count();
        
        $confirmed = Booking::whereHas('property', function($query) use ($partnerId) {
            $query->where('user_id', $partnerId);
        })->where('status', 'confirmed')->count();
        
        $pending = Booking::whereHas('property', function($query) use ($partnerId) {
            $query->where('user_id', $partnerId);
        })->where('status', 'pending')->count();
        
        $cancelled = Booking::whereHas('property', function($query) use ($partnerId) {
            $query->where('user_id', $partnerId);
        })->where('status', 'cancelled')->count();
        
        return [
            'total_bookings' => $totalBookings,
            'confirmed' => $confirmed,
            'pending' => $pending,
            'cancelled' => $cancelled
        ];
    }

    private function getPropertyType(int $categoryId): string
    {
        $category = PropertyCategory::find($categoryId);
        return $category?->name ?? 'Property';
    }

    private function getCategoryIdByType(string $type): ?int
    {
        $categoryMap = [
            'apartments' => 'Apartment',
            'homes' => 'Home', 
            'hotels' => 'Hotel',
            'alternative-places' => 'Alternative Place'
        ];
        
        $categoryName = $categoryMap[$type] ?? null;
        if (!$categoryName) return null;
        
        $category = \App\Models\PropertyCategory::where('name', $categoryName)->first();
        return $category?->id;
    }
}