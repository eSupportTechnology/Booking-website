<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoomAmenity extends Model
{
      use HasFactory;

      protected $table = 'room_amenity';

      protected $fillable = [
            'room_id',
            'amenity_id',
      ];

      

}
