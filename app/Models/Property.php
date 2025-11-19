<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\PropertyAvailabilitySetting;

class Property extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'category_id',
        'subcategory_id',
        'subtype_id',
        'address_type_id',
        'title',
        'description',
        'address',
        'apartment',
        'city',
        'country',
        'zipcode',
        'latitude',
        'longitude',
        'channel_manager',
        'status',
        'stars',
        'group',
        'payment_method',
        'invoicing_info',
        'open_for_bookings',
        'wizard_step',
        'property_wizard_step',
        'pricing_wizard_step',
        'adult_price',
        'child_price',
        'commission_rate',
        'total_price_with_commission',
        'currency',
    ];
    public function photos()
    {
        return $this->hasMany(PropertyPhoto::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'property_amenity', 'property_id', 'amenity_id');
    }
    // public function languages()
    // {
    //     return $this->belongsToMany(Languages::class, 'property_languages', 'property_id', 'language_id');
    // }
    public function bedrooms()
    {
        return $this->hasMany(PropertyBedroom::class);
    }
    public function additionalDetails()
    {
        return $this->hasOne(PropertyAdditionalDetail::class);
    }

    public function policies()
    {
        return $this->hasOne(PropertyPolicy::class);
    }

    public function partnerVerification()
    {
        return $this->hasOne(PartnerVerification::class);
    }

    public function services()
    {
        return $this->hasOne(PropertyService::class);
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'property_language', 'property_id', 'language_id');
    }

    public function hostProfile()
    {
        return $this->hasOne(\App\Models\PropertyHostProfile::class);
    }

    public function pricing()
{
    return $this->hasOne(PropertyPricing::class, 'property_id');
}


    public function addressType()
    {
        return $this->belongsTo(AddressType::class);
    }

    public function facilities()
    {
        return $this->hasMany(PropertyFacility::class);
    }

    public function availabilitySettings()
    {
        return $this->hasOne(PropertyAvailabilitySetting::class);
    }

    public function cancellationPolicy()
    {
        return $this->hasOne(CancellationPolicy::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function hostReviews()
    {
        return $this->hasMany(HostReview::class);
    }

    public function category()
    {
        return $this->belongsTo(PropertyCategory::class, 'category_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the partner that owns the property (through user relationship).
     */
    public function partner()
    {
        return $this->hasOneThrough(Partner::class, User::class, 'id', 'user_id', 'user_id', 'id');
    }

    public function accommodation()
    {
        return $this->hasOne(Accommodation::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'property_id');
    }

    public function deals()
    {
        return $this->hasMany(Deal::class);
    }

    public function subtype()
{
    return $this->belongsTo(PropertySubtype::class, 'subtype_id');
}


    public function seasonalPricings()
    {
        return $this->hasMany(SeasonalPricing::class);
    }

    /**
     * Get the effective commission rate for this property.
     * Always uses admin's global commission rate.
     */
    public function getEffectiveCommissionRate(): float
    {
        return \App\Models\AdminSettings::getGlobalCommissionRate();
    }

    /**
     * Calculate total price with commission: base + (base * commission_rate)
     */
    public function calculateTotalPriceWithCommission(): float
    {
        $basePrice = ($this->adult_price ?? 0) + ($this->child_price ?? 0);
        $commissionRate = $this->getEffectiveCommissionRate() / 100;
        $commission = $basePrice * $commissionRate;

        return $basePrice + $commission;
    }

    /**
     * Get pricing breakdown with commission details: base + (base * commission_rate)
     */
    public function getPricingBreakdown(): array
    {
        $adultPrice = $this->adult_price ?? 0;
        $childPrice = $this->child_price ?? 0;
        $basePrice = $adultPrice + $childPrice;
        $commissionRate = $this->getEffectiveCommissionRate() / 100;
        $totalCommission = $basePrice * $commissionRate;

        return [
            'adult_price' => $adultPrice,
            'child_price' => $childPrice,
            'commission_rate' => $commissionRate,
            'total_base_price' => $basePrice,
            'total_commission' => $totalCommission,
            'total_price_with_commission' => $basePrice + $totalCommission,
            'using_admin_default' => true,
            'admin_default_rate' => $commissionRate
        ];
    }

    /**
     * Check if using admin's default commission rate.
     * Always returns true since partners cannot set custom rates.
     */
    public function isUsingAdminDefaultRate(): bool
    {
        return true;
    }
}
