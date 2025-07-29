<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'category_id',
        'subcategory_id',
        'subtype_id',
        'address_type_id',
        'title',
        'description',
        'address',
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
    ];
    public function photos()
    {
        return $this->hasMany(PropertyPhoto::class);
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


}
