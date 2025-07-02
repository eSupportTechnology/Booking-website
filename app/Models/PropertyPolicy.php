<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyPolicy extends Model
{
    use HasFactory;
    protected $fillable = ['property_id', 'cancellation_policy', 'check_in_time', 'check_out_time', 'smoking_allowed', 'pets_allowed'];
    public $timestamps = false;
}
