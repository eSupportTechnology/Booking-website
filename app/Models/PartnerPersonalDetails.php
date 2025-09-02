<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartnerPersonalDetails extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'display_name',
        'phone_number',
        'date_of_birth',
        'gender',
        'nationality',
        'language',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'profile_image',
    ];

    protected $dates = ['deleted_at'];

    // Relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
