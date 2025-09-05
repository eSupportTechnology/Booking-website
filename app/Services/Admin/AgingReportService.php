<?php

namespace App\Services\Admin;

use App\DTOs\Admin\AgingReportDTO;
use App\Models\Booking;
use App\Models\PropertyCategory;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AgingReportService
{
    public function getAgingReportData(Request $request): AgingReportDTO
    {
        $dateFrom = $request->get('date_from', Carbon::now()->subDays(30)->format('Y-m-d'));
        $dateTo = $request->get('date_to', Carbon::now()->format('Y-m-d'));
        $propertyType = $request->get('property_type');
        $status = $request->get('status');

        $bookings = $this->getFilteredBookings($dateFrom, $dateTo, $propertyType, $status);
        $agingData = $this->categorizeByAge($bookings);

        return new AgingReportDTO(
            dateFrom: $dateFrom,
            dateTo: $dateTo,
            propertyType: $propertyType,
            status: $status,
            agingData: $agingData,
            propertyTypes: PropertyCategory::all()->toArray(),
            statuses: ['pending', 'confirmed', 'cancelled', 'completed']
        );
    }

    private function getFilteredBookings(string $dateFrom, string $dateTo, ?int $propertyType, ?string $status)
    {
        $query = Booking::with(['property.category', 'user'])
            ->whereBetween('created_at', [$dateFrom, $dateTo]);

        if ($propertyType) {
            $query->whereHas('property', fn($q) => $q->where('category_id', $propertyType));
        }

        if ($status) {
            $query->where('status', $status);
        }

        return $query->get();
    }

    private function categorizeByAge($bookings): array
    {
        return [
            '0-7 days' => $bookings->filter(fn($b) => $b->created_at->diffInDays() <= 7),
            '8-30 days' => $bookings->filter(fn($b) => $b->created_at->diffInDays() > 7 && $b->created_at->diffInDays() <= 30),
            '31-60 days' => $bookings->filter(fn($b) => $b->created_at->diffInDays() > 30 && $b->created_at->diffInDays() <= 60),
            '60+ days' => $bookings->filter(fn($b) => $b->created_at->diffInDays() > 60)
        ];
    }
}