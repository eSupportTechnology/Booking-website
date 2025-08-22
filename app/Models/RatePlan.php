<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RatePlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'name',
        'price',
        'discount',
        'min_nights',
        'is_refundable',
        'cancellation_days',
        'policy_notes',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
