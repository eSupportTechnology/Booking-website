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
        return $this->hasOne(\App\Models\PropertyPricing::class);
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

    public function propertySubcategory()
    {
        return $this->belongsTo(PropertySubcategory::class, 'subcategory_id');
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
        return $this->hasMany(Booking::class);
    }
}
