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
        'company_logo',
        'full_name',
        'nic_number',
        'phone',
        'country_code',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email' => 'string',
    ];

    // Hash password automatically
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    public function isCompany(): bool
    {
        return $this->account_type === 'company';
    }

    public function isIndividual(): bool
    {
        return $this->account_type === 'individual';
    }
}
