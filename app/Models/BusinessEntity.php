<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessEntity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'accommodation_id',
        'business_name',
        'trading_name',
        'address',
        'zip_code',
        'city',
        'country',
    ];

    protected $dates = ['deleted_at'];

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }

    public function property()
    {
        return $this->hasOneThrough(Property::class, Accommodation::class);
    }
} 