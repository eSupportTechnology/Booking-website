<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'contact_number',
        'status'
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    /**
     * Get the user that owns the partner.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the properties for the partner.
     */
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class, 'user_id', 'user_id');
    }

    /**
     * Get the partner settings.
     */
    public function settings(): HasOne
    {
        return $this->hasOne(PartnerSettings::class, 'user_id', 'user_id');
    }

    /**
     * Get the properties count attribute.
     */
    public function getPropertiesCountAttribute(): int
    {
        return $this->properties()->count();
    }

    /**
     * Get the effective commission rate for this partner.
     * Returns individual rate if set, otherwise global rate.
     */
    public function getEffectiveCommissionRate(): float
    {
        $partnerRate = $this->settings?->commission_rate;
        
        if ($partnerRate !== null) {
            return (float) $partnerRate;
        }
        
        // Get global commission rate from admin settings
        return \App\Models\AdminSettings::getGlobalCommissionRate();
    }

    /**
     * Get commission invoices for this partner.
     */
    public function commissionInvoices()
    {
        return $this->hasMany(CommissionInvoice::class);
    }

    /**
     * Check if partner has overdue invoices.
     */
    public function hasOverdueInvoices(): bool
    {
        return $this->commissionInvoices()
            ->where('status', 'pending')
            ->where('due_date', '<', now())
            ->exists();
    }

    /**
     * Deactivate all properties for this partner.
     */
    public function deactivateProperties(): void
    {
        $this->properties()->update(['status' => 'suspended']);
    }
}
