<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoomAvailability extends Model
{
   use HasFactory;
    public $timestamps = false;
    protected $fillable = ['room_id', 'date', 'is_available', 'price_override', 'min_stay', 'max_stay'];
}
