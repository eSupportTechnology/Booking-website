<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;
    protected $fillable = ['property_id', 'name', 'description', 'price_per_night', 'max_guests', 'bed_count', 'bathroom_count', 'size_sq_m'];
    public function availability() {
        return $this->hasMany(RoomAvailability::class);
    }
    public function property() {
        return $this->belongsTo(Property::class);
    }
}
