<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPersonalDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'display_name',
        'phone_number',
        'date_of_birth',
        'nationality',
        'gender',
        'country',
        'street',
        'city',
        'postcode',
        'passport_name',
        'issuingCountry',
        'passportNumber',
        'passport_expiry_date',
        'profile_image',
    ];
    protected $casts = [
    'date_of_birth' => 'date',
    'user_id' => 'integer'
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
