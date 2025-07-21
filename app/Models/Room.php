<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RoomType;
use App\Models\RoomBed;

class Room extends Model
{
    protected $fillable = [
        'property_id', 'room_type_id', 'name', 'description',
        'price_per_night', 'max_guests', 'bathroom_count', 'size_sq_m'
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function beds()
    {
        return $this->hasMany(RoomBed::class);
    }
}
