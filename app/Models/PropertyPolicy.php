<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyPolicy extends Model
{
    use HasFactory;

    protected $table = 'property_policies';
    public $timestamps = false;

    protected $fillable = [
        'property_id',
        'cancellation_policy',
        'check_in_from',
        'check_in_until',
        'check_out_from',
        'check_out_until',
        'smoking_allowed',
        'pets_allowed',
        'parties_allowed',
        'pets_fees',
        'children_allowed'
    ];

}
