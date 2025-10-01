<?php

namespace App\Services;

use App\Models\Partner;
use App\Models\CommissionInvoice;
use App\Models\Booking;
use Carbon\Carbon;

class CommissionService
{
    /**
     * Calculate commission for a booking.
     */
    public function calculateCommission(Partner $partner, float $bookingAmount): float
    {
        return $bookingAmount * $partner->getEffectiveCommissionRate();
    }

    /**
     * Generate invoice for partner's pending commissions.
     */
    public function generateInvoice(Partner $partner): ?CommissionInvoice
    {
        $amount = $this->getPendingCommissionAmount($partner);
        
        if ($amount <= 0) {
            return null;
        }

        return CommissionInvoice::create([
            'partner_id' => $partner->id,
            'invoice_number' => $this->generateInvoiceNumber($partner),
            'amount' => $amount,
            'due_date' => now()->addDays(15),
            'status' => 'pending'
        ]);
    }

    /**
     * Get pending commission amount for partner.
     */
    private function getPendingCommissionAmount(Partner $partner): float
    {
        $bookings = Booking::whereHas('property', fn($q) => $q->where('user_id', $partner->user_id))
            ->where('status', 'confirmed')
            ->where('created_at', '>=', now()->subDays(15))
            ->get();

        return $bookings->sum(fn($booking) => $this->calculateCommission($partner, $booking->total_price));
    }

    /**
     * Generate unique invoice number.
     */
    private function generateInvoiceNumber(Partner $partner): string
    {
        return 'INV-' . $partner->id . '-' . now()->format('Ymd') . '-' . rand(1000, 9999);
    }

    /**
     * Deactivate properties for partners with overdue invoices.
     */
    public function deactivateOverduePartners(): int
    {
        $overduePartners = Partner::whereHas('commissionInvoices', function($q) {
            $q->where('status', 'pending')
              ->where('due_date', '<', now());
        })->get();

        foreach ($overduePartners as $partner) {
            $partner->deactivateProperties();
        }

        return $overduePartners->count();
    }

    /**
     * Get aging report data.
     */
    public function getAgingReport(): array
    {
        $invoices = CommissionInvoice::with('partner.user')
            ->where('status', 'pending')
            ->get()
            ->groupBy('partner_id');

        $report = [];
        foreach ($invoices as $partnerId => $partnerInvoices) {
            $partner = $partnerInvoices->first()->partner;
            $totalAmount = $partnerInvoices->sum('amount');
            
            $buckets = ['0-15' => 0, '16-30' => 0, '31-45' => 0, '46+' => 0];
            
            foreach ($partnerInvoices as $invoice) {
                $daysOverdue = now()->diffInDays($invoice->due_date, false);
                $bucket = match(true) {
                    $daysOverdue <= 15 => '0-15',
                    $daysOverdue <= 30 => '16-30', 
                    $daysOverdue <= 45 => '31-45',
                    default => '46+'
                };
                $buckets[$bucket] += $invoice->amount;
            }

            $report[] = [
                'partner_name' => $partner->first_name . ' ' . $partner->last_name,
                'partner_email' => $partner->user->email,
                'total_amount' => $totalAmount,
                'buckets' => $buckets
            ];
        }

        return $report;
    }
}