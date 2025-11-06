<?php

namespace App\Services\Admin;

use App\DTOs\Admin\CommissionAgingDTO;
use App\Models\Booking;
use App\Models\Partner;
use App\Models\AdminSettings;
use App\Helpers\CurrencyHelper;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CommissionAgingService
{
    private const INVOICEABLE_DAYS = 15;

    private function getCommissionRate(): float
    {
        $admin = Auth::guard('admin')->user();
        $settings = $admin?->settings;
        return $settings?->commission_rate ?? 0.15;
    }

    public function getCommissionAgingData(Request $request): CommissionAgingDTO
    {
        $dateFrom = $request->get('date_from', Carbon::now()->subDays(90)->format('Y-m-d'));
        $dateTo = $request->get('date_to', Carbon::now()->format('Y-m-d'));
        $partnerId = $request->get('partner_id');

        $bookings = $this->getInvoiceableBookings($dateFrom, $dateTo, $partnerId);
        $commissionData = $this->calculateCommissionAging($bookings);
        $totals = $this->calculateTotals($commissionData);

        return new CommissionAgingDTO(
            dateFrom: $dateFrom,
            dateTo: $dateTo,
            partnerId: $partnerId,
            commissionData: $commissionData,
            partners: Partner::with('user')->get()->toArray(),
            totals: $totals,
            commissionRate: $this->getCommissionRate()
        );
    }

    private function getInvoiceableBookings(string $dateFrom, string $dateTo, ?int $partnerId)
    {
        $invoiceableDate = Carbon::now()->subDays(self::INVOICEABLE_DAYS);
        
        $query = Booking::with(['property.user.partner', 'user'])
            ->whereHas('property')
            ->where('status', 'confirmed')
            ->where('created_at', '<=', $invoiceableDate)
            ->whereBetween('created_at', [$dateFrom, $dateTo]);

        if ($partnerId) {
            $query->whereHas('property.user.partner', fn($q) => $q->where('id', $partnerId));
        }

        return $query->get();
    }

    private function calculateCommissionAging($bookings): array
    {
        $commissionData = [];
        
        foreach ($bookings as $booking) {
            $partner = $booking->property->user->partner;
            if (!$partner) continue;

            $partnerKey = $partner->id;
            
            // Convert booking amount to USD first, then calculate commission
            $bookingAmountUsd = CurrencyHelper::convertPrice(
                $booking->total_price, 
                $booking->currency ?? 'USD', 
                'USD'
            );
            $commissionAmount = $bookingAmountUsd * $this->getCommissionRate();
            
            $daysOverdue = Carbon::now()->diffInDays($booking->created_at->addDays(self::INVOICEABLE_DAYS));
            $bucket = $this->getAgingBucket($daysOverdue);

            if (!isset($commissionData[$partnerKey])) {
                $commissionData[$partnerKey] = [
                    'partner_name' => ($partner->first_name ?? '') . ' ' . ($partner->last_name ?? ''),
                    'partner_email' => $partner->user->email ?? '',
                    'invoice_number' => 'INV-' . str_pad($partner->id, 6, '0', STR_PAD_LEFT),
                    'total_amount' => 0,
                    'buckets' => [
                        '0-15' => 0,
                        '16-30' => 0,
                        '31-45' => 0,
                        '46-60' => 0,
                        '61-75' => 0,
                        '75+' => 0
                    ]
                ];
            }

            $commissionData[$partnerKey]['total_amount'] += $commissionAmount;
            $commissionData[$partnerKey]['buckets'][$bucket] += $commissionAmount;
        }

        return array_values($commissionData);
    }

    private function getAgingBucket(int $daysOverdue): string
    {
        return match (true) {
            $daysOverdue <= 15 => '0-15',
            $daysOverdue <= 30 => '16-30',
            $daysOverdue <= 45 => '31-45',
            $daysOverdue <= 60 => '46-60',
            $daysOverdue <= 75 => '61-75',
            default => '75+'
        };
    }

    private function calculateTotals(array $commissionData): array
    {
        $totals = [
            'total_amount' => 0,
            'buckets' => [
                '0-15' => 0,
                '16-30' => 0,
                '31-45' => 0,
                '46-60' => 0,
                '61-75' => 0,
                '75+' => 0
            ]
        ];

        foreach ($commissionData as $data) {
            $totals['total_amount'] += $data['total_amount'];
            foreach ($data['buckets'] as $bucket => $amount) {
                $totals['buckets'][$bucket] += $amount;
            }
        }

        return $totals;
    }
}