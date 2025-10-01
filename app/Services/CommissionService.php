<?php

namespace App\Services;

use App\Models\Partner;
use App\Models\AdminSettings;

class CommissionService
{
    /**
     * Calculate commission amount for a partner based on booking amount.
     */
    public function calculateCommission(Partner $partner, float $bookingAmount): float
    {
        $commissionRate = $partner->getEffectiveCommissionRate();
        return $bookingAmount * $commissionRate;
    }

    /**
     * Get commission rate for a partner (individual or global).
     */
    public function getCommissionRate(Partner $partner): float
    {
        return $partner->getEffectiveCommissionRate();
    }

    /**
     * Check if partner has individual commission rate.
     */
    public function hasIndividualRate(Partner $partner): bool
    {
        return $partner->settings?->commission_rate !== null;
    }

    /**
     * Get global commission rate.
     */
    public function getGlobalCommissionRate(): float
    {
        return AdminSettings::getGlobalCommissionRate();
    }

    /**
     * Set individual commission rate for a partner.
     */
    public function setPartnerCommissionRate(Partner $partner, ?float $rate): void
    {
        $partner->settings()->updateOrCreate(
            ['user_id' => $partner->user_id],
            ['commission_rate' => $rate]
        );
    }

    /**
     * Remove individual commission rate for a partner.
     */
    public function removePartnerCommissionRate(Partner $partner): void
    {
        $partner->settings()->update(['commission_rate' => null]);
    }
}