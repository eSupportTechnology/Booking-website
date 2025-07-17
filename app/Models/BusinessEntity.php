<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessEntity extends Model
{
    use HasFactory;

    protected $fillable = [
        'accommodation_id',
        'business_name',
        'trading_name',
        'address',
        'zip_code',
        'city',
        'country',
    ];

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }
} 