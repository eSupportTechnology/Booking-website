<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Mail\PartnerResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'is_partner',
        'is_car_renter',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'deleted_at' => 'datetime',
        ];
    }

    // Scope for Google authenticated users
    public function scopeGoogleUsers($query)
    {
        return $query->whereNotNull('google_id');
    }

    // Check if user registered via Google
    public function isGoogleUser(): bool
    {
        return !empty($this->google_id);
    }

    // Check if user is a partner
    public function isPartner(): bool
    {
        return (bool) $this->is_partner;
    }

    // Check if user is a car renter
    public function isCarRenter(): bool
    {
        return (bool) $this->is_car_renter;
    }

    // Make user a partner
    public function makePartner(): void
    {
        $this->update(['is_partner' => true]);
    }

    // Make user a car renter
    public function makeCarRenter(): void
    {
        $this->update(['is_car_renter' => true]);
    }

    //partners relationship
    public function partner()
    {
        return $this->hasOne(Partner::class);
    }

    public function partnerPersonalDetail()
    {
        return $this->hasOne(PartnerPersonalDetails::class);
    }

    public function businessEntity()
    {
        return $this->hasOne(BusinessEntity::class);
    }

    public function customerPersonalDetail()
    {
        return $this->hasOne(CustomerPersonalDetails::class);
    }

    public function travelerDetails()
    {
        return $this->hasOne(TravelersDetails::class);
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
}
