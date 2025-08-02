<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyAvailabilitySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'availability_mode',
        'availability_days',
        'allow_long_stays',
        'max_nights',
        'sync_tripadvisor',
    ];

    protected $casts = [
        'allow_long_stays' => 'boolean',
        'sync_tripadvisor' => 'boolean',
        'availability_days' => 'integer',
        'max_nights' => 'integer',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
