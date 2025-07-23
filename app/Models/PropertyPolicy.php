<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyPolicy extends Model
{
    use HasFactory;
    protected $fillable = [
        'property_id',
        'check_in_time',
        'check_out_time',
        'check_in_until',
        'check_out_until',
        'smoking_allowed',
        'pets_allowed',
        'children_allowed',
        'party_allowed',
        'cancellation_policy'
    ];
    public $timestamps = false;
}
