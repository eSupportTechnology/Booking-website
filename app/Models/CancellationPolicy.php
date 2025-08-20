<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancellationPolicy extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'free_cancellation_days',
        'protection_enabled',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
