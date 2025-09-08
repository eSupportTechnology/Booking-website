<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class CarRenter extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'car_renters';

    protected $fillable = [
        'email',
        'password',
        'account_type',
        'company_name',
        'business_reg_no',
        'tin_number',
        'company_logo',
        'full_name',
        'nic_number',
        'phone',
        'phone2',
        'country_code',
        'address',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * When setting password: only bcrypt if it does not already look like a bcrypt hash.
     * This avoids double-hashing.
     */
    public function setPasswordAttribute($value): void
    {
        if ($value === null || $value === '') {
            return;
        }

        // bcrypt hashes look like: $2y$10$..................................................
        if (preg_match('/^\$2[aby]\$.{56}$/', $value)) {
            $this->attributes['password'] = $value;
            return;
        }

        $this->attributes['password'] = bcrypt($value);
    }

    public function isCompany(): bool
    {
        return $this->account_type === 'company';
    }

    public function isIndividual(): bool
    {
        return $this->account_type === 'individual';
    }
    public function cars()
{
    return $this->hasMany(Car::class, 'car_renter_id');
}
    public function taxis()
{
    return $this->hasMany(Taxi::class, 'car_renter_id');

}
}