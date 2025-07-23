<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerVerification extends Model
{
    protected $table = 'partner_verifications';
    protected $fillable = [
        'property_id',
        'type',
        'full_name',
        'national_id',
        'company_name',
        'registration_number',
    ];


    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
